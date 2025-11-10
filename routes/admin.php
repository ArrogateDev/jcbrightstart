<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\GeminiLogController;
use App\Http\Controllers\Admin\InstructController;
use App\Http\Controllers\Admin\PersonalController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CommonController;
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
//获取图形验证码
Route::get('get-captcha', [CommonController::class, 'captcha']);
//登录
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'abilities:admin']], function ($route) {

    //公共模块
    $route->group(['prefix' => 'main'], function ($route) {
        $route->get('get-roles', [CommonController::class, 'getRole']);
        $route->get('get-menu-tree', [CommonController::class, 'getMenuTree']);
    });

    $route->get('dashboard', [CommonController::class, 'dashboard']);

    //账号信息
    $route->get('info', [PersonalController::class, 'info']);
    //修改账号信息
    $route->put('info', [PersonalController::class, 'update']);
    //退出登录
    $route->put('logout', [AuthController::class, 'logout']);

    //指令管理
    $route->group(['prefix' => 'instruct', 'middleware' => 'admin:InstructManage'], function ($route) {
        //指令列表
        $route->get('/', [InstructController::class, 'index'])->middleware('admin:InstructList');
        //修改指令
        $route->put('/{instruct}', [InstructController::class, 'update'])->middleware('admin:InstructEdit');
    });

    //记录管理
    $route->group(['prefix' => 'log', 'middleware' => 'admin:GeminiLogManage'], function ($route) {
        //记录列表
        $route->get('/', [GeminiLogController::class, 'index'])->middleware('admin:GeminiLogList');
        //删除记录
        $route->delete('/{log}', [GeminiLogController::class, 'destroy'])->middleware('admin:GeminiLogDelete');
    });

    //系统设置
    $route->group(['prefix' => 'system', 'middleware' => 'admin:SystemManage'], function ($route) {
        //角色管理
        $route->group(['prefix' => 'roles', 'middleware' => 'admin:RoleManage'], function ($route) {
            //角色列表
            $route->get('/', [RoleController::class, 'index'])->middleware('admin:RoleList');
            //创建角色
            $route->post('/', [RoleController::class, 'store'])->middleware('admin:RoleAdd');
            //修改角色
            $route->put('/{role}', [RoleController::class, 'update'])->middleware('admin:RoleEdit');
            //删除角色
            $route->delete('/{role}', [RoleController::class, 'destroy'])->middleware('admin:RoleDelete');
            //权限列表
            $route->get('/menus', [RoleController::class, 'menus'])->middleware('admin:RoleEdit');
        });
        //管理员模块
        $route->group(['prefix' => 'admin', 'middleware' => 'admin:AdminManage'], function ($route) {
            //管理员列表
            $route->get('/', [AdminController::class, 'index'])->middleware('admin:AdminList');
            //创建管理员
            $route->post('/', [AdminController::class, 'store'])->middleware('admin:AdminAdd');
            //修改管理员
            $route->put('/{admin}', [AdminController::class, 'update'])->middleware('admin:AdminEdit');
            //删除管理员
            $route->delete('/{admin}', [AdminController::class, 'destroy'])->middleware('admin:AdminDelete');
        });
    });
});
