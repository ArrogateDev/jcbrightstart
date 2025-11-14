<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizResultController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Principal Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

//登录页
Route::get('/login.html', [LoginController::class, 'index'])->name('admin.login.html');
//登录
Route::post('/login.html', [LoginController::class, 'handleLogin']);

Route::group(['middleware' => ['auth:admin', 'auth.session']], function ($route) {
    //退出登录
    $route->delete('logout.html', [AuthController::class, 'logout']);
    //修改头像
    $route->post('set-avatar.html', [ProfileController::class, 'handleSetAvatar'])->name('admin.set-avatar.html');
    //删除头像
    $route->delete('remove-avatar.html', [ProfileController::class, 'handleRemoveAvatar'])->name('admin.remove-avatar.html');

    $route->group(['middleware' => 'admin:MainMenuManage'], function ($route) {
        $route->get('/dashboard.html', [DashboardController::class, 'index'])->middleware('admin:DashboardList')->name('admin.dashboard.html');
        $route->get('/course.html', [CourseController::class, 'index'])->middleware('admin:CourseList')->name('admin.course.html');
        $route->get('/user.html', [UserController::class, 'index'])->middleware('admin:UserList')->name('admin.user.html');
        $route->get('/quiz.html', [QuizController::class, 'index'])->middleware('admin:QuizList')->name('admin.quiz.html');
        $route->get('/quiz-results.html', [QuizResultController::class, 'index'])->middleware('admin:QuizResultsList')->name('admin.quiz-results.html');
        $route->get('/certificate.html', [CertificateController::class, 'index'])->middleware('admin:CertificateList')->name('admin.certificate.html');
    });

    $route->group(['prefix' => 'system', 'middleware' => 'admin:AuthorityManage'], function ($route) {
        //角色列表
        $route->get('role.html', [RoleController::class, 'index'])->middleware('admin:RoleList')->name('admin.role.html');
        //创建角色
        $route->post('role.html', [RoleController::class, 'store'])->middleware('admin:RoleAdd');
        //修改角色
        $route->put('/role/{role}.html', [RoleController::class, 'update'])->middleware('admin:RoleEdit');
        //删除角色
        $route->delete('/role/{role}.html', [RoleController::class, 'destroy'])->middleware('admin:RoleDelete');

        //管理员列表
        $route->get('/admin.html', [AdminController::class, 'index'])->middleware('admin:AdminList')->name('admin.admin.html');
        //创建管理员
        $route->post('/admin.html', [AdminController::class, 'store'])->middleware('admin:AdminAdd');
        //修改管理员
        $route->put('/admin/{admin}.html', [AdminController::class, 'update'])->middleware('admin:AdminEdit');
        //删除管理员
        $route->delete('/admin/{admin}.html', [AdminController::class, 'destroy'])->middleware('admin:AdminDelete');
    });

    $route->get('/profile.html', [ProfileController::class, 'index'])->name('admin.profile.html');
    $route->get('/settings.html', [SettingController::class, 'index'])->name('admin.settings.html');
    $route->post('/settings.html', [SettingController::class, 'handleSetting']);

    $route->get('/change-password.html', [ChangePasswordController::class, 'index'])->name('admin.change-password.html');
    $route->post('/change-password.html', [ChangePasswordController::class, 'handleChangePassword']);
});
