<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class UserController extends Controller
{

    public function index()
    {
        $active = strpos(url()->current(), 'teacher.html') ? 'teacher' : 'parent';

        $ages = User::AGE_MAPS;

        return view('admin.user.index', compact('active', 'ages'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');
        $field = $request->query('field');
        $sort = $request->query('sort');

        $list = User::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($field, function ($query) use ($field, $sort) {
                $query->orderBy($field, $sort);
            }, function ($query) {
                $query->orderBy('id');
            })
            ->select('id', 'avatar', 'email', 'full_name', 'first_name', 'last_name', 'gender', 'age', 'role', 'status', 'created_at')
            ->paginate(limit_page());

        $list->append(['gender_text', 'age_text']);

        return $this->responseSuccess($list);
    }

    /**
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

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
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

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function export(Request $request)
    {
        $keyword = $request->query('keyword');
        $date = Carbon::now()->format('Ymd');

        $result = User::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->select('id', 'avatar', 'email', 'full_name', 'first_name', 'last_name', 'gender', 'age', 'role', 'status', 'created_at');

        try {

            $file_path = 'files/export/uset/' . $date . '/';
            $file = $file_path . uniqid() . '.xlsx';
            $path = storage_path('app/public/');
            if (!file_exists($path . $file_path)) {
                mkdir($path . $file_path, 0755, true);
            }

            $result = (new FastExcel($result->get()))->export($path . $file, function ($item) {
                return [
                    __('邮箱') => $item->email,
                    __('姓名') => $item->full_name,
                    __('性别') => $item->gender_text,
                    __('注册时间') => Carbon::parse($item->created_at)->toDateString(),
                ];
            });

            if (!$result) {
                throw new  \Exception('fail');
            }

            return $this->responseSuccess(['url' => route('admin.download.html', ['file' => $file])]);
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('fail'), ResponseCode::SERVER_ERR);
        }
    }
}
