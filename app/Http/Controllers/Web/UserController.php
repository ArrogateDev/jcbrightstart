<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{


    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $request->user('user');
        $user->remove_tokens('user');

        return $this->responseSuccess(null, '退出成功');
    }
}
