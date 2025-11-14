<?php

use App\Http\Controllers\Web\VerificationCodeController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\User\CertificateController;
use App\Http\Controllers\Web\User\ChangePasswordController;
use App\Http\Controllers\Web\User\CourseController;
use App\Http\Controllers\Web\User\DashboardController;
use App\Http\Controllers\Web\User\ProfileController;
use App\Http\Controllers\Web\User\QuizController;
use App\Http\Controllers\Web\User\SettingController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/index.html', [IndexController::class, 'index'])->name('index.html');
Route::get('/index-{no}.html', [IndexController::class, 'other'])->name('index-other.html');
Route::get('/login.html', [LoginController::class, 'index'])->name('login.html');
Route::post('/login.html', [LoginController::class, 'handleLogin']);
Route::post('/google-quick-login.html', [LoginController::class, 'handleGoogleQuickLogin'])->name('google-quick-login.html');
Route::post('/apple-quick-login.html', [LoginController::class, 'handleAppleQuickLogin'])->name('apple-quick-login.html');
Route::get('/register.html', [RegisterController::class, 'index'])->name('register.html');
Route::post('/register.html', [RegisterController::class, 'handleRegister']);
Route::get('/forgot-password.html', [ForgotPasswordController::class, 'index'])->name('forgot-password.html');
Route::post('/forgot-password.html', [ForgotPasswordController::class, 'handleForgotPassword']);
Route::get('/reset-password.html', [ResetPasswordController::class, 'index'])->name('reset-password.html');
Route::post('/reset-password.html', [ResetPasswordController::class, 'handleResetPassword']);
//获取验证码
Route::post('get-code', [VerificationCodeController::class, 'getCode'])->name('get-code');

Route::middleware(['auth', 'auth.session'])->group(function ($route) {

    $route->get('/logout.html', [UserController::class, 'logout'])->name('logout.html');

    $route->group(['prefix' => 'user'], function ($route) {
        $route->get('/dashboard.html', [DashboardController::class, 'index'])->name('user.dashboard.html');
        $route->get('/profile.html', [ProfileController::class, 'index'])->name('user.profile.html');
        $route->get('/course.html', [CourseController::class, 'index'])->name('user.course.html');
        $route->get('/certificate.html', [CertificateController::class, 'index'])->name('user.certificate.html');
        $route->get('/quiz.html', [QuizController::class, 'index'])->name('user.quiz.html');
        $route->get('/settings.html', [SettingController::class, 'index'])->name('user.settings.html');
        $route->get('/change-password.html', [ChangePasswordController::class, 'index'])->name('user.change-password.html');
    });
});
