<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $user = Auth::guard('web')->user();
        if ($user) {
            $request->session()->forget([
                'login_web_' . sha1($user->getAuthIdentifier()),
                'password_hash_web'
            ]);
        }

        $request->session()->regenerateToken();

        return $this->responseSuccess(null, __('退出成功'));
    }
}
