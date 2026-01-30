<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Manage\Authority;
use App\Models\Manage\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $admin = $request->user('admin');
        $role = $admin->role;
        $role->load('permissions');
        $role_id = $role->id ?? 0;
        $role_level = $role->level ?? 0;
        $admin_permissions = $role->permissions->pluck('id')->toArray();

        $superiors = Role::query()
            ->when($role_id != 1, function ($query) use ($role_level, $role_id) {
                $query->where('level', '>', $role_level)->orWhere('id', $role_id);
            })
            ->orderBy('id')
            ->select('id as value', 'name as label')
            ->get();

        Cache::tags(['AdminPermission'])->flush();
        $nodes = Cache::tags(['AdminPermission'])->rememberForever('MenuTreeList:' . $role_id, function () use ($role_id, $admin_permissions) {
            $permissions = Authority::query()
                ->when($role_id !== 1, function ($query) use ($admin_permissions) {
                    $query->whereIn('id', $admin_permissions);
                })
                ->orderBy('key')
                ->select('id', 'name as text', 'id as key', 'type', 'pid')
                ->get()
                ->toArray();

            return authority_format($permissions, 0, true);
        });
        $nodes = json_encode($nodes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return view('admin.role', compact('superiors', 'nodes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $admin = $request->user('admin');
        $role_id = $admin->role->id ?? 0;
        $role_level = $admin->role->level ?? 0;

        $name = $request->query('name');
        $created_at = $request->query('created_at');

        $list = Role::query()
            ->with(['permission_ids', 'superior:id,name'])
            ->when($role_id != 1, function ($query) use ($role_level) {
                $query->where('level', '>', $role_level);
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($created_at, function ($query) use ($created_at) {
                $query->whereDate('created_at', $created_at);
            })
            ->paginate(limit_page());

        $list->map(function ($item) {
            $item->superior_name = $item->superior->name ?? '-';
            $item->nodes = $item->permission_ids->pluck('authority_id')->toArray();
        });
        $list->makeHidden(['permission_ids']);

        return $this->responseSuccess($list);
    }

    /**
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $admin_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_role_store_lock:$admin_id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'status']);
        $pid = (int)$request->input('pid');
        if (!($parent = Role::find($pid))) {
            throw new ApiException(__('父級角色不存在'), ResponseCode::PARAM_ERR);
        }

        try {

            $role = new Role();
            foreach ($inputs as $field => $value) {
                $role->$field = $value;
            }

            $role->pid = $parent->id;
            $role->level = $parent->level + 1;
            if ($role->save() === false) {
                throw new \Exception('role:failed');
            }

            $permissions = $request->input('nodes');
            if (!empty($permissions)) {
                $permissions = array_unique($permissions);
                $permissions = Authority::query()->whereIn('id', $permissions)->pluck('id')->toArray();

                $role->permissions()->sync($permissions);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('创建失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        if (!(($lock = Cache::lock("submit_role_update_lock:$role->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        if ($role->id == 1) {
            throw new ApiException(__('系统内置角色，不允许修改'), ResponseCode::PARAM_ERR);
        }

        $inputs = $request->only(['name', 'status']);
        $pid = $request->input('pid');
        $parent = Role::find($pid);
        if (!$parent) {
            throw new ApiException(__('父級角色不存在'), ResponseCode::PARAM_ERR);
        }

        try {

            foreach ($inputs as $field => $value) {
                $role->$field = $value;
            }

            $role->pid = $parent->id;
            $role->level = $parent->level + 1;
            if ($role->save() === false) {
                throw new \Exception('role:failed');
            }

            $permissions = $request->input('nodes');
            if (!empty($permissions)) {
                $permissions = array_unique($permissions);
                $permissions = Authority::query()->whereIn('id', $permissions)->pluck('id')->toArray();

                $role->permissions()->sync($permissions);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('修改失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if (!(($lock = Cache::lock("submit_role_destroy_lock:$role->id", 360))->get())) {
            throw new ApiException(__('操作过于频繁，请稍后再试'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        if ($role->id === 1) {
            throw new ApiException(__('默认角色，不能删除'), ResponseCode::SERVER_ERR);
        }

        try {

            if ($role->admins) {
                foreach ($role->admins as $admin) {
                    $admin->roles()->detach($role->id);
                }
            }

            $role->permissions()->detach($role->id);
            $role->delete();

            return $this->responseSuccess(null, __('删除成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('删除失败'), $e->getCode());
        }
    }
}
