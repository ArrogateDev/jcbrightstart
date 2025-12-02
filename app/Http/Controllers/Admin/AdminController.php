<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Manage\Admin;
use App\Models\Manage\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $admin = $request->user('admin');
        $role_id = $admin->role->id ?? 0;
        $role_level = $admin->role->level ?? 0;

        $superiors = Role::query()
            ->when($role_id != 1, function ($query) use ($role_level) {
                $query->where('level', '>', $role_level);
            })
            ->orderBy('id')
            ->select('id as value', 'name as label')
            ->get();

        return view('admin.admin', compact('superiors'));
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

        $list = Admin::query()
            ->with(['role:id,name'])
            ->when($admin->id != 1, function ($query) {
                $query->where('id', '>', 1);
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($account, function ($query) use ($account) {
                $query->where('account', 'like', '%' . $account . '%');
            })
            ->when($role_id, function ($query) use ($role_id) {
                $query->whereHas('role', function ($query) use ($role_id) {
                    $query->where('id', $role_id);
                });
            })
            ->select('id', 'account', 'avatar', 'name', 'status', 'created_at')
            ->paginate(limit_page());

        $list->map(function ($item) {
            $item->role_id = $item->role?->id ?? 0;
            $item->role_name = $item->role?->name ?? '';
        });
        $list->makeHidden(['role']);

        return $this->responseSuccess($list);
    }

    /**
     * @param AdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AdminRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_admin_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'account', 'password', 'status']);

        try {

            $admin = new Admin();
            foreach ($inputs as $field => $value) {
                $admin->$field = $value;
            }

            if ($admin->save() === false) {
                throw new \Exception('admin:failed');
            }

            $role_id = $request->input('role_id');
            if ($role_id && $admin->role_logs()->sync([$role_id]) == false) {
                throw new \Exception('role_logs:failed');
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param AdminRequest $request
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        if (!(($lock = Cache::lock("submit_admin_update_lock:$admin->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'status']);
        $password = $request->input('password');

        try {

            foreach ($inputs as $field => $value) {
                $admin->$field = $value;
            }
            $password && $admin->password = $password;

            if ($admin->save() === false) {
                throw new \Exception('admin:failed');
            }

            $role_id = $request->input('role_id');
            if ($role_id && $admin->role_logs()->sync([$role_id]) == false) {
                throw new \Exception('role_logs:failed');
            }

            return $this->responseSuccess(null, __('修改成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Admin $admin)
    {
        if (!(($lock = Cache::lock("submit_admin_destroy_lock:$admin->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        if ($admin->id === 1) {
            throw new ApiException(__('默认角色，不能删除'), ResponseCode::SERVER_ERR);
        }
        try {

            $admin->delete();
            $admin->tokens()->delete();

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }
}
