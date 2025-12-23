<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\MapsController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\User\CertificateController;
use App\Http\Controllers\Web\User\ChangePasswordController;
use App\Http\Controllers\Web\User\CourseController;
use App\Http\Controllers\Web\User\DashboardController;
use App\Http\Controllers\Web\User\ProfileController;
use App\Http\Controllers\Web\User\QuizController;
use App\Http\Controllers\Web\User\SettingController;
use App\Http\Controllers\Web\VerificationCodeController;
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
Route::post('get-code', [VerificationCodeController::class, 'getCode'])->name('get-code');

Route::get('/latest-news.html', [NewsController::class, 'index'])->name('news.html');
Route::get('/latest-news/list.html', [NewsController::class, 'list'])->name('news.list.html');
Route::get('/latest-news/{news}.html', [NewsController::class, 'show'])->name('news.show.html');

Route::get('/maps.html', [MapsController::class, 'index'])->name('maps.html');

Route::middleware(['auth', 'auth.session'])->group(function ($route) {

    $route->delete('/logout.html', [AuthController::class, 'logout'])->name('user.logout.html');

    $route->group(['prefix' => 'user'], function ($route) {
        //修改头像
        $route->post('set-avatar.html', [ProfileController::class, 'handleSetAvatar'])->name('user.set-avatar.html');
        //删除头像
        $route->delete('remove-avatar.html', [ProfileController::class, 'handleRemoveAvatar'])->name('user.remove-avatar.html');
        $route->get('/dashboard.html', [DashboardController::class, 'index'])->name('user.dashboard.html');
        $route->get('/profile.html', [ProfileController::class, 'index'])->name('user.profile.html');
        $route->get('/course.html', [CourseController::class, 'index'])->name('user.course.html');
        $route->get('/course/list.html', [CourseController::class, 'list'])->name('user.course.list.html');
        $route->get('/certificate.html', [CertificateController::class, 'index'])->name('user.certificate.html');
        $route->get('/quiz.html', [QuizController::class, 'index'])->name('user.quiz.html');

        $route->get('/settings.html', [SettingController::class, 'index'])->name('user.settings.html');
        $route->post('/settings.html', [SettingController::class, 'handleSetting']);

        $route->get('/change-password.html', [ChangePasswordController::class, 'index'])->name('user.change-password.html');
        $route->post('/change-password.html', [ChangePasswordController::class, 'handleChangePassword']);
    });
});

Route::get('marker', [\App\Http\Controllers\CommonController::class, 'marker'])->name('marker');
Route::get('{page}', [PageController::class, 'index'])->name('page');
