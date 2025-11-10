<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\VerificationCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//登录
Route::post('login', [AuthController::class, 'login']);
//快捷登录
Route::post('quick-login', [AuthController::class, 'handleQuickLogin']);
//注册
Route::post('register', [AuthController::class, 'register']);;
//忘记密码
Route::post('forgot-password', [AuthController::class, 'handleForgotPassword']);
//获取验证码
Route::post('get-code', [VerificationCodeController::class, 'getCode']);

Route::group(['middleware' => ['auth:sanctum', 'abilities:user']], function ($route) {

    //退出登录
    $route->delete('logout', [AuthController::class, 'logout']);

    $route->post('/recognition', [IndexController::class, 'index']);
    $route->get('/recognition/{log}', [IndexController::class, 'detail']);
});
