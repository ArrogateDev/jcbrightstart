<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    public function index()
    {
        return view('admin.course.list');
    }

    public function view()
    {
        return view('admin.course.new');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = Course::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->select('id', 'avatar', 'email', 'full_name', 'first_name', 'last_name', 'gender', 'age', 'role', 'status', 'created_at')
            ->paginate(limit_page());

        $list->append(['gender_text', 'age_text']);

        return $this->responseSuccess($list);
    }

    /**
     * @param CourseRequest $request
     * @param Course $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CourseRequest $request, Course $user)
    {
        if (!(($lock = Cache::lock("submit_user_update_lock:$user->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['first_name', 'last_name', 'email', 'gender', 'age', 'status']);
        $password = $request->input('password');

        try {

            foreach ($inputs as $field => $value) {
                $user->$field = $value;
            }
            $password && $user->password = $password;

            if ($user->save() === false) {
                throw new \Exception('user:failed');
            }

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Course $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Course $user)
    {
        if (!(($lock = Cache::lock("submit_user_destroy_lock:$user->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {
            $password = time();
            $user->password = time();
            $user->save();
            Auth::logoutOtherDevices($password);
            $user->delete();

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }
}
