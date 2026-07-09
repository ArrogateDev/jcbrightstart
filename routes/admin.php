<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\Auth\ProfileController;
use App\Http\Controllers\Admin\Auth\SettingController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\News\NewsCategoryController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\Quiz\QuizController;
use App\Http\Controllers\Admin\Quiz\QuizResultController;
use App\Http\Controllers\Admin\Resource\ResourceCategoryController;
use App\Http\Controllers\Admin\Resource\ResourceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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

//登录页
Route::get('/login.html', [AuthController::class, 'index'])->name('admin.login.html');
//登录
Route::post('/login.html', [AuthController::class, 'handleLogin']);

Route::middleware(['auth:admin'])->group(function ($route) {

    //公共模块
    $route->group(['prefix' => 'main'], function ($route) {
        $route->get('get-quiz-list.html', [CommonController::class, 'getQuizList'])->name('admin.get-quiz-list.html');
        $route->get('get-certificate-list.html', [CommonController::class, 'getCertificateList'])->name('admin.get-certificate-list.html');
        $route->get('get-news-category-list.html', [CommonController::class, 'getNewsCategoryList'])->name('admin.get-news-category-list.html');
        $route->get('get-resource-category-list.html', [CommonController::class, 'getResourceCategoryList'])->name('admin.get-resource-category-list.html');
        $route->post('upload-image.html', [CommonController::class, 'uploadImage'])->name('admin.upload-image.html');
    });

    //下载文件
    $route->get('download.html', [CommonController::class, 'download'])->name('admin.download.html');

    //退出登录
    $route->delete('logout.html', [AuthController::class, 'logout'])->name('admin.logout.html');
    //修改头像
    $route->post('set-avatar.html', [ProfileController::class, 'handleSetAvatar'])->name('admin.set-avatar.html');
    //删除头像
    $route->delete('remove-avatar.html', [ProfileController::class, 'handleRemoveAvatar'])->name('admin.remove-avatar.html');

    $route->group(['middleware' => 'admin.permission:MainMenuManage'], function ($route) {
        $route->get('/dashboard.html', [DashboardController::class, 'index'])->middleware('admin.permission:DashboardList')->name('admin.dashboard.html');
        $route->get('/dashboard/user.html', [DashboardController::class, 'getUser'])->middleware('admin.permission:DashboardList')->name('admin.dashboard.user.html');

        //课程列表页
        $route->get('course.html', [CourseController::class, 'index'])->middleware('admin.permission:CourseList')->name('admin.course.html');
        //课程列表
        $route->get('course/list.html', [CourseController::class, 'list'])->middleware('admin.permission:CourseList')->name('admin.course.list.html');
        //创建课程页
        $route->get('course/new.html', [CourseController::class, 'view'])->middleware('admin.permission:CertificateAdd')->name('admin.course.store.view.html');
        //创建课程
        $route->post('course.html', [CourseController::class, 'store'])->middleware('admin.permission:CertificateAdd')->name('admin.course.store.html');
        //修改课程页
        $route->get('/course/{course}.html', [CourseController::class, 'view'])->middleware('admin.permission:CourseEdit')->name('admin.course.update.view.html');
        //修改课程
        $route->put('/course/{course}.html', [CourseController::class, 'update'])->middleware('admin.permission:CourseEdit')->name('admin.course.update.html');
        //修改课程状态
        $route->put('/course/status/{course}.html', [CourseController::class, 'status'])->middleware('admin.permission:CourseEdit')->name('admin.course.status.html');
        //删除课程
        $route->delete('/course/{course}.html', [CourseController::class, 'destroy'])->middleware('admin.permission:CourseDelete')->name('admin.course.destroy.html');

        //老师列表页
        $route->get('teacher.html', [UserController::class, 'index'])->middleware('admin.permission:TeacherList')->name('admin.teacher.html');
        //老师列表
        $route->get('teacher/list.html', [UserController::class, 'list'])->middleware('admin.permission:TeacherList')->name('admin.teacher.list.html');
        //老师导出
        $route->get('teacher/export.html', [UserController::class, 'export'])->middleware('admin.permission:TeacherList')->name('admin.teacher.export.html');
        //修改老师
        $route->put('/teacher/{user}.html', [UserController::class, 'update'])->middleware('admin.permission:TeacherEdit')->name('admin.teacher.update.html');
        //删除老师
        $route->delete('/teacher/{user}.html', [UserController::class, 'destroy'])->middleware('admin.permission:TeacherDelete');

        //家长列表页
        $route->get('parent.html', [UserController::class, 'index'])->middleware('admin.permission:ParentList')->name('admin.parent.html');
        //家长列表
        $route->get('parent/list.html', [UserController::class, 'list'])->middleware('admin.permission:ParentList')->name('admin.parent.list.html');
        //家长导出
        $route->get('parent/export.html', [UserController::class, 'export'])->middleware('admin.permission:ParentList')->name('admin.parent.export.html');
        //修改家长
        $route->put('/parent/{user}.html', [UserController::class, 'update'])->middleware('admin.permission:ParentEdit')->name('admin.parent.update.html');
        //删除家长
        $route->delete('/parent/{user}.html', [UserController::class, 'destroy'])->middleware('admin.permission:ParentDelete');

        //测验列表页
        $route->get('quiz.html', [QuizController::class, 'index'])->middleware('admin.permission:QuizList')->name('admin.quiz.html');
        //测验列表
        $route->get('quiz/list.html', [QuizController::class, 'list'])->middleware('admin.permission:QuizList')->name('admin.quiz.list.html');
        //创建测验
        $route->post('quiz.html', [QuizController::class, 'store'])->middleware('admin.permission:QuizAdd')->name('admin.quiz.store.html');
        //修改测验
        $route->put('/quiz/{quiz}.html', [QuizController::class, 'update'])->middleware('admin.permission:QuizEdit')->name('admin.quiz.update.html');
        //删除测验
        $route->delete('/quiz/{quiz}.html', [QuizController::class, 'destroy'])->middleware('admin.permission:QuizDelete');

        //测验结果列表页
        $route->get('{quiz}/results.html', [QuizResultController::class, 'index'])->middleware('admin.permission:QuizResultList')->name('admin.quiz-results.html');
        //测验结果列表
        $route->get('{quiz}/results/list.html', [QuizResultController::class, 'list'])->middleware('admin.permission:QuizResultList')->name('admin.quiz-results.list.html');
        //删除测验结果
        $route->delete('/quiz-results/{result}.html', [QuizResultController::class, 'destroy'])->middleware('admin.permission:QuizResultDelete');

        //证书列表页
        $route->get('certificate.html', [CertificateController::class, 'index'])->middleware('admin.permission:CertificateList')->name('admin.certificate.html');
        //证书列表
        $route->get('certificate/list.html', [CertificateController::class, 'list'])->middleware('admin.permission:CertificateList')->name('admin.certificate.list.html');
        //创建证书模板
        $route->post('certificate.html', [CertificateController::class, 'store'])->middleware('admin.permission:CertificateAdd')->name('admin.certificate.store.html');
        //修改证书模板
        $route->put('/certificate/{certificate}.html', [CertificateController::class, 'update'])->middleware('admin.permission:CertificateEdit')->name('admin.certificate.update.html');
        //删除证书模板
        $route->delete('/certificate/{certificate}.html', [CertificateController::class, 'destroy'])->middleware('admin.permission:CertificateDelete');
    });

    $route->group(['middleware' => 'admin.permission:WebpageManage'], function ($route) {
        //消息列表页
        $route->get('news.html', [NewsController::class, 'index'])->middleware('admin.permission:NewsList')->name('admin.news.html');
        //消息列表
        $route->get('news/list.html', [NewsController::class, 'list'])->middleware('admin.permission:NewsList')->name('admin.news.list.html');
        //创建消息页
        $route->get('news/new.html', [NewsController::class, 'view'])->middleware('admin.permission:NewsAdd')->name('admin.news.store.view.html');
        //创建消息
        $route->post('news.html', [NewsController::class, 'store'])->middleware('admin.permission:NewsAdd')->name('admin.news.store.html');
        //修改消息
        $route->put('/news/{news}.html', [NewsController::class, 'update'])->middleware('admin.permission:NewsEdit')->name('admin.news.update.html');
        //修改课程页
        $route->get('/news/edit/{news}.html', [NewsController::class, 'view'])->middleware('admin.permission:NewsEdit')->name('admin.news.update.view.html');
        //修改课程状态
        $route->put('/news/status/{news}.html', [NewsController::class, 'status'])->middleware('admin.permission:NewsEdit')->name('admin.news.status.html');
        //删除消息
        $route->delete('/news/{news}.html', [NewsController::class, 'destroy'])->middleware('admin.permission:NewsDelete');

        //消息分类列表页
        $route->get('news/category.html', [NewsCategoryController::class, 'index'])->middleware('admin.permission:NewsCategoryList')->name('admin.news-category.html');
        //消息分类列表
        $route->get('news/category/list.html', [NewsCategoryController::class, 'list'])->middleware('admin.permission:NewsCategoryList')->name('admin.news-category.list.html');
        //创建消息分类
        $route->post('news/category.html', [NewsCategoryController::class, 'store'])->middleware('admin.permission:NewsCategoryAdd')->name('admin.news-category.store.html');
        //修改消息分类
        $route->put('/news/category/{category}.html', [NewsCategoryController::class, 'update'])->middleware('admin.permission:NewsCategoryEdit')->name('admin.news-category.update.html');
        //删除消息分类
        $route->delete('/news/category/{category}.html', [NewsCategoryController::class, 'destroy'])->middleware('admin.permission:NewsCategoryDelete');

        //资源列表页
        $route->get('resource.html', [ResourceController::class, 'index'])->middleware('admin.permission:NewsList')->name('admin.resource.html');
        //资源列表
        $route->get('resource/list.html', [ResourceController::class, 'list'])->middleware('admin.permission:NewsList')->name('admin.resource.list.html');
        //创建资源页
        $route->get('resource/new.html', [ResourceController::class, 'view'])->middleware('admin.permission:NewsAdd')->name('admin.resource.store.view.html');
        //创建资源
        $route->post('resource.html', [ResourceController::class, 'store'])->middleware('admin.permission:NewsAdd')->name('admin.resource.store.html');
        //修改资源
        $route->put('/resource/{resource}.html', [ResourceController::class, 'update'])->middleware('admin.permission:NewsEdit')->name('admin.resource.update.html');
        //修改课程页
        $route->get('/resource/edit/{resource}.html', [ResourceController::class, 'view'])->middleware('admin.permission:NewsEdit')->name('admin.resource.update.view.html');
        //修改课程状态
        $route->put('/resource/status/{resource}.html', [ResourceController::class, 'status'])->middleware('admin.permission:NewsEdit')->name('admin.resource.status.html');
        //删除资源
        $route->delete('/resource/{resource}.html', [ResourceController::class, 'destroy'])->middleware('admin.permission:NewsDelete');

        //资源分类列表页
        $route->get('resource/category.html', [ResourceCategoryController::class, 'index'])->middleware('admin.permission:NewsCategoryList')->name('admin.resource-category.html');
        //资源分类列表
        $route->get('resource/category/list.html', [ResourceCategoryController::class, 'list'])->middleware('admin.permission:NewsCategoryList')->name('admin.resource-category.list.html');
        //创建资源分类
        $route->post('resource/category.html', [ResourceCategoryController::class, 'store'])->middleware('admin.permission:NewsCategoryAdd')->name('admin.resource-category.store.html');
        //修改资源分类
        $route->put('/resource/category/{category}.html', [ResourceCategoryController::class, 'update'])->middleware('admin.permission:NewsCategoryEdit')->name('admin.resource-category.update.html');
        //删除资源分类
        $route->delete('/resource/category/{category}.html', [ResourceCategoryController::class, 'destroy'])->middleware('admin.permission:NewsCategoryDelete');
    });

    $route->group(['prefix' => 'system', 'middleware' => 'admin.permission:AuthorityManage'], function ($route) {
        //角色列表页
        $route->get('role.html', [RoleController::class, 'index'])->middleware('admin.permission:RoleList')->name('admin.role.html');
        //角色列表
        $route->get('role/list.html', [RoleController::class, 'list'])->middleware('admin.permission:RoleList')->name('admin.role.list.html');
        //创建角色
        $route->post('role.html', [RoleController::class, 'store'])->middleware('admin.permission:RoleAdd')->name('admin.role.store.html');
        //修改角色
        $route->put('/role/{role}.html', [RoleController::class, 'update'])->middleware('admin.permission:RoleEdit')->name('admin.role.update.html');
        //删除角色
        $route->delete('/role/{role}.html', [RoleController::class, 'destroy'])->middleware('admin.permission:RoleDelete');

        //管理员列表页
        $route->get('/admin.html', [AdminController::class, 'index'])->middleware('admin.permission:AdminList')->name('admin.admin.html');
        //管理员列表
        $route->get('admin/list.html', [AdminController::class, 'list'])->middleware('admin.permission:AdminList')->name('admin.admin.list.html');
        //创建管理员
        $route->post('/admin.html', [AdminController::class, 'store'])->middleware('admin.permission:AdminAdd')->name('admin.admin.store.html');
        //修改管理员
        $route->put('/admin/{admin}.html', [AdminController::class, 'update'])->middleware('admin.permission:AdminEdit')->name('admin.admin.update.html');
        //删除管理员
        $route->delete('/admin/{admin}.html', [AdminController::class, 'destroy'])->middleware('admin.permission:AdminDelete');
    });

    $route->get('/profile.html', [ProfileController::class, 'index'])->name('admin.profile.html');
    $route->get('/settings.html', [SettingController::class, 'index'])->name('admin.settings.html');
    $route->post('/settings.html', [SettingController::class, 'handleSetting']);

    $route->get('/change-password.html', [ChangePasswordController::class, 'index'])->name('admin.change-password.html');
    $route->post('/change-password.html', [ChangePasswordController::class, 'handleChangePassword']);
});
