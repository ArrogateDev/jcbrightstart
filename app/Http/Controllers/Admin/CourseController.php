<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course\Course;
use App\Models\Course\CourseChapter;
use App\Models\Course\CourseChapterUnit;
use App\Models\CourseQuiz;
use App\Models\Quiz;
use App\Tools\FileTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::query()
            ->groupBy('status')
            ->select(DB::raw('count(id) as count'), 'status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.course.list', ['courses' => $courses]);
    }

    public function view(Course $course)
    {
        $course->load([
            'chapters:id,course_id,title',
            'chapters.units',
            'chapters.units.quiz:id,title',
            'certificate:id,name'
        ]);

        if (empty($course->id)) {
            $chapter = new CourseChapter();
            $chapter->title = '';
            $chapter->course_id = null;

            $unit = new CourseChapterUnit();
            $unit->title = '';
            $unit->course_id = null;
            $unit->chapter_id = null;
            $unit->type = 0;
            $unit->quiz_id = 0;

            $chapter->setRelation('units', collect([$unit]));
            $course->setRelation('chapters', collect([$chapter]));
        }

        return view('admin.course.new', ['course' => $course]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');
        $status = $request->query('status');
        $field = $request->query('field');
        $sort = $request->query('sort');

        $base_query = Course::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        $list = (clone $base_query)
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderBy('id');
            })
            ->paginate(limit_page());

        $unit_query = CourseChapterUnit::query()
            ->whereIn('course_id', (clone $base_query)->select('id'));

        $units = (clone $unit_query)
            ->groupBy('course_id')
            ->select(DB::raw('count(id) as num'), 'course_id')
            ->pluck('num', 'course_id');

        $list->map(function ($item) use ($base_query, $units) {
            $item->url = route('admin.course.update.view.html', ['course' => $item->id]);
            $item->units = $units[$item->id] ?? 0;

            $item->quizzes = Quiz::query()
                ->whereIn('id', CourseChapterUnit::query()->whereIn('course_id', (clone $base_query)->select('id'))->select('id'))
                ->sum('question_num') ?? 0;
        });

        return $this->responseSuccess($list);
    }

    /**
     * @param CourseRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(CourseRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_course_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'category_id', 'level', 'language', 'short', 'description', 'acquire', 'requirements', 'certificate_id', 'status']);

        try {

            $file = $request->file('thumbnail');

            DB::beginTransaction();

            $course = new Course();
            foreach ($inputs as $key => $value) {
                $course->$key = $value;
            }

            if ($file) {
                $file_path = FileTool::existsAndMake('course');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);
                $course->thumbnail = $file_path . $file_name;
            }

            if ($course->save() === false) {
                throw new \Exception('course:failed', ResponseCode::SERVER_ERR);
            }

            $this->handleSaveRelationalData($course, $request);

            DB::commit();

            return $this->responseSuccess(['id' => $course->id], __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param CourseRequest $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(CourseRequest $request, Course $course)
    {
        if (!(($lock = Cache::lock("submit_course_update_lock:$course->id", 360))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'category_id', 'level', 'language', 'short', 'description', 'acquire', 'requirements', 'certificate_id', 'status']);

        try {

            DB::beginTransaction();

            $file = $request->file('thumbnail');
            if ($file) {
                $file_path = FileTool::existsAndMake('course');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $course->getRawOriginal('thumbnail');
                FileTool::existsAnddelete($old_path);

                $course->thumbnail = $file_path . $file_name;
            }

            foreach ($inputs as $key => $value) {
                $course->$key = $value;
            }

            if ($course->save() === false) {
                throw new \Exception('course:failed', ResponseCode::SERVER_ERR);
            }

            $this->handleSaveRelationalData($course, $request);

            DB::commit();

            return $this->responseSuccess(['id' => $course->id], __('成功'));
        } catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function status(Request $request, Course $course)
    {
        if (!(($lock = Cache::lock("submit_course_status_lock:$course->id", 360))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $status = (int)$request->input('status');

        if ($status === Course::STATUS_PUBLISHED) {
            $course->load([
                'chapters:id,course_id,title',
                'chapters.units',
            ]);

            $course_data = $course->toArray();
            $course_data['thumbnail'] = '';
            $course_data['thumbnail_url'] = $course->getRawOriginal('thumbnail');
            $course_data['status'] = $status;

            $course_request = CourseRequest::createFrom($request);
            $course_request->merge($course_data);
            $course_request->setMethod('PUT');
            $currentRoute = $request->route();
            if ($currentRoute) {
                $course_request->setRouteResolver(function () use ($currentRoute, $course) {
                    $currentRoute->setParameter('course', $course);
                    return $currentRoute;
                });
            }

            $validator = Validator::make(
                $course_data,
                $course_request->rules(),
                $course_request->messages()
            );

            $course_request->withValidator($validator);

            if ($validator->fails()) {
                throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
            }
        }

        try {

            $course->status = $status;
            if ($course->save() === false) {
                throw new \Exception('course:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(0, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(Course $course)
    {
        if (!(($lock = Cache::lock("submit_course_destroy_lock:$course->id", 360))->get())) {
            throw new ApiException(__('操作频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            DB::beginTransaction();


            $chapters = $course->chapters()->with('units')->get();
            foreach ($chapters as $chapter) {
                foreach ($chapter->units as $unit) {
                    if ($unit->file) {
                        $unit_file_path = $unit->getRawOriginal('file');
                        FileTool::existsAnddelete($unit_file_path);
                    }
                }
                $chapter->units()->delete();
            }
            $course->chapters()->delete();

            CourseQuiz::where('course_id', $course->id)->delete();

            $old_path = $course->getRawOriginal('thumbnail');
            FileTool::existsAnddelete($old_path);

            $course->delete();

            DB::commit();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 保存章节和单元
     * @param Course $course
     * @param CourseRequest $request
     * @return void
     * @throws \Exception
     */
    private function handleSaveRelationalData(Course $course, CourseRequest $request)
    {
        $chapters = $request->input('chapters', []);

        $chapter_ids = $course->chapters()->pluck('id')->toArray();
        $new_chapter_ids = [];

        foreach ($chapters as $index => $item) {
            $chapter_id = $item['id'] ?? null;
            $chapter = $course->chapters()->where('id', $chapter_id)->first();
            if (!$chapter) {
                $chapter = new CourseChapter();
                $chapter->course_id = $course->id;
            }

            $chapter->title = $item['title'] ?? null;
            if ($chapter->save() === false) {
                throw new \Exception('chapter:failed', ResponseCode::SERVER_ERR);
            }

            $new_chapter_ids[] = $chapter->id;

            $units = $item['units'] ?? [];
            $unit_ids = $chapter->units()->pluck('id')->toArray();
            $new_unit_ids = [];

            foreach ($units as $unit_index => $unit_item) {
                $unit_id = $unit_item['id'] ?? null;
                $unit = $chapter->units()->where('id', $unit_id)->first();

                if (!$unit) {
                    $unit = new CourseChapterUnit();
                    $unit->course_id = $course->id;
                    $unit->chapter_id = $chapter->id;
                }

                $unit->title = $unit_item['title'] ?? null;
                $unit->type = $unit_item['type'] ?? 0;
                $unit->description = $unit_item['description'] ?? '';
                $unit->quiz_id = $unit_item['quiz_id'] ?? 0;
                $unit->content = $unit_item['content'] ?? '';

                if ($unit->type == 0) {
                    $unit->video_url = $unit_item['video_url'] ?? null;
                    if ($unit->file) {
                        $old_path = $unit->getRawOriginal('file');
                        FileTool::existsAnddelete($old_path);
                        $unit->file = null;
                    }
                } else {
                    $unit->video_url = null;
                    $file = $request->file("chapters.$index.units.$unit_index.pdf");

                    if ($file && $file->isValid()) {
                        if ($unit->file) {
                            $old_path = $unit->getRawOriginal('file');
                            FileTool::existsAnddelete($old_path);
                        }

                        $file_path = FileTool::existsAndMake('course/units');
                        $extension = $file->getClientOriginalExtension();
                        $file_name = uniqid() . '.' . $extension;
                        Storage::putFileAs($file_path, $file, $file_name);
                        $unit->file = $file_path . $file_name;
                    }
                }

                if ($unit->save() === false) {
                    throw new \Exception('unit:failed', ResponseCode::SERVER_ERR);
                }

                $new_unit_ids[] = $unit->id;
            }

            $units_to_delete = array_diff($unit_ids, $new_unit_ids);
            if (!empty($units_to_delete)) {
                foreach ($units_to_delete as $unit_id_to_delete) {
                    $unit_to_delete = CourseChapterUnit::find($unit_id_to_delete);
                    if ($unit_to_delete && $unit_to_delete->file) {
                        $old_path = $unit_to_delete->getRawOriginal('file');
                        FileTool::existsAnddelete($old_path);
                    }
                }
                CourseChapterUnit::whereIn('id', $units_to_delete)->delete();
            }
        }

        $chapters_to_delete = array_diff($chapter_ids, $new_chapter_ids);
        if (!empty($chapters_to_delete)) {
            $units_to_delete = CourseChapterUnit::whereIn('chapter_id', $chapters_to_delete)->get();
            foreach ($units_to_delete as $unit_to_delete) {
                if ($unit_to_delete->file) {
                    $old_path = $unit_to_delete->getRawOriginal('file');
                    FileTool::existsAnddelete($old_path);
                }
            }
            CourseChapter::whereIn('id', $chapters_to_delete)->delete();
        }
    }
}
