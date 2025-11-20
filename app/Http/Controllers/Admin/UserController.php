<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $active = strpos(url()->current(), 'teacher.html') ? 'teacher' : 'parent';

        $ages = User::AGE_MAPS;

        return view('admin.user', compact('active', 'ages'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = User::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->select('id', 'avatar', 'email', 'full_name', 'first_name', 'last_name', 'gender', 'age', 'role', 'status', 'created_at')
            ->paginate(limit_page());

        $list->append(['gender_text', 'age_text']);

        return $this->responseSuccess($list);
    }

    /**
     * 修改
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
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

            return $this->responseSuccess(null, '修改成功');
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException('修改失败', ResponseCode::SERVER_ERR);
        }
    }

    /**
     * 删除
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
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

            return $this->responseSuccess(null, '删除成功');
        } catch (\Exception $e) {
            throw new ApiException('删除失败', $e->getCode());
        }
    }
}
