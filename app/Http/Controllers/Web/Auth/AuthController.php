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
        $locale = $request->session()->get('locale');

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session(['locale' => $locale]);
        App::setLocale($locale);

        return $this->responseSuccess(null, __('退出成功'));
    }
}
