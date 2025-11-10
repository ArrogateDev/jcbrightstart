<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstructRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    /**
     * 获取信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $admin = $request->user('admin');
        $admin->load(['role:id,name']);

        $result['name'] = $admin->name;
        $result['avatar'] = asset($admin->avatar) ? Storage::disk('public')->url($admin->avatar) : '';
        $result['account'] = $admin->account;
        $result['roles'] = [$admin->role->name];

        return $this->responseSuccess($result);
    }

    /**
     * 修改信息
     *
     * @param InstructRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(Request $request)
    {
        $admin = $request->user('admin');
        $inputs = $request->only(['name', 'avatar', 'old_password', 'password', 'password_confirmation']);
        $mime = '';

        $validator = Validator::make($inputs, [
            'name' => 'nullable|unique:admins,name,' . $admin->id,
            'avatar' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use (&$mime) {
                    $info = getimagesize($value);
                    if (!in_array($info['mime'], ['image/jpeg', 'image/png'])) {
                        return $fail('无效的Base64图片编码.');
                    }
                    $mime = $info['mime'];
                    return true;
                }
            ],
            'old_password' => 'nullable|bail|size:32|current_password:admin',
            'password' => 'nullable|bail|string||size:32|confirmed',
            'password_confirmation' => 'nullable|bail|string|size:32',
        ], [
            'name.unique' => '名称已存在',
            'old_password.size' => '原密码密码错误',
            'old_password.current_password' => '原密码密码错误',
            'password.string' => '密码格式错误',
            'password.size' => '密码格式错误',
            'password.confirmed' => '请输入确认密码',
            'password_confirmation.string' => '确认密码格式错误',
            'password_confirmation.size' => '确认密码格式错误',
        ]);

        if ($validator->fails()) {
            throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
        }

        unset($inputs['old_password'], $inputs['password_confirmation']);
        if (isset($inputs['avatar']) && !empty($base64 = explode(',', $inputs['avatar'])[1])) {
            $image = base64_decode($base64);
            $filename = $admin->id . str_replace('image/', '.', $mime);

            $path = 'admin/avatar/' . $filename;

            Storage::put($path, $image);

            $inputs['avatar'] = $path . '?t=' . time();
        }

        foreach ($inputs as $key => $value) {
            if ($value === null) continue;
            $admin->$key = $value;
        }

        if ($admin->save() === false) {
            throw new ApiException('修改失败', ResponseCode::SERVER_ERR);
        }

        return $this->responseSuccess($base64, '修改成功');
    }
}
