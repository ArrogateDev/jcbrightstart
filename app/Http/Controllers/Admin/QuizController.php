<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuizRequest;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{

    public function index()
    {
        return view('admin.quiz.list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $name = $request->query('name');
        $account = $request->query('account');
        $role_id = $request->query('role_id');

        $admin = $request->user('admin');

        $list = Quiz::query()
//            ->with(['role:id,name'])
//            ->when($admin->id != 1, function ($query) {
//                $query->where('id', '>', 1);
//            })
//            ->when($name, function ($query) use ($name) {
//                $query->where('name', 'like', '%' . $name . '%');
//            })
//            ->when($account, function ($query) use ($account) {
//                $query->where('account', 'like', '%' . $account . '%');
//            })
//            ->when($role_id, function ($query) use ($role_id) {
//                $query->whereHas('role', function ($query) use ($role_id) {
//                    $query->where('id', $role_id);
//                });
//            })
//            ->select('id', 'account', 'avatar', 'name', 'status', 'created_at')
            ->paginate(limit_page());

//        $list->map(function ($item) {
//            $item->role_id = $item->role?->id ?? 0;
//            $item->role_name = $item->role?->name ?? '';
//        });
//        $list->makeHidden(['role']);

        return $this->responseSuccess($list);
    }

    /**
     * @param QuizRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuizRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_quiz_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'questions']);

        try {

            $quiz = new Quiz();
            foreach ($inputs as $field => $value) {
                $quiz->$field = $value;
            }

            $quiz->question_num = count($inputs['questions']);
            if ($quiz->save() === false) {
                throw new \Exception('quiz:failed');
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param QuizRequest $request
     * @param Quiz $quiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        if (!(($lock = Cache::lock("submit_quiz_update_lock:$quiz->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['title', 'questions']);

        try {

            foreach ($inputs as $field => $value) {
                $quiz->$field = $value;
            }
            $quiz->question_num = count($inputs['questions']);

            if ($quiz->save() === false) {
                throw new \Exception('quiz:failed');
            }

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Quiz $quiz
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Quiz $quiz)
    {
        if (!(($lock = Cache::lock("submit_quiz_destroy_lock:$quiz->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

//        if ($quiz->id === 1) {
//            throw new ApiException(__('默认角色，不能删除'), ResponseCode::SERVER_ERR);
//        }
//        try {
//
//            $quiz->delete();
//            $quiz->tokens()->delete();
//
//            return $this->responseSuccess(null, __('删除成功'));
//        } catch (\Exception $e) {
//            throw new ApiException(__('删除失败'), $e->getCode());
//        }
    }
}
