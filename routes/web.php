<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Web\AboutUsController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\DownloadController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\MapsController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ResourceController;
use App\Http\Controllers\Web\User\CertificateController;
use App\Http\Controllers\Web\User\ChangePasswordController;
use App\Http\Controllers\Web\User\CourseController as UserCourseController;
use App\Http\Controllers\Web\User\DashboardController;
use App\Http\Controllers\Web\User\ProfileController;
use App\Http\Controllers\Web\User\QuizController;
use App\Http\Controllers\Web\User\SettingController;
use App\Http\Controllers\Web\VerificationCodeController;
use App\Http\Controllers\Web\LanguageController;
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

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::post('/message.html', [IndexController::class, 'handleMessage'])->name('message.html');

Route::get('/about-us.html', [AboutUsController::class, 'index'])->name('about-us.html');

Route::get('/latest-news.html', [NewsController::class, 'index'])->name('news.html');
Route::get('/latest-news/more.html', [NewsController::class, 'more'])->name('news.more.html');
Route::get('/latest-news/list.html', [NewsController::class, 'list'])->name('news.list.html');
Route::get('/latest-news/{news}.html', [NewsController::class, 'show'])->name('news.show.html');

Route::get('/maps.html', [MapsController::class, 'index'])->name('maps.html');
Route::get('/maps/list.html', [MapsController::class, 'list'])->name('maps-list.html');

Route::get('/resource-kit.html', [ResourceController::class, 'index'])->name('resource.html');
Route::get('/resource-kit/liist.html', [ResourceController::class, 'list'])->name('resource.list.html');
Route::get('/resource-kit/{resource}.html', [ResourceController::class, 'show'])->name('resource.show.html')->whereNumber('resource');

Route::get('/resource-kit/share.html', [ResourceController::class, 'index'])->name('resource.share.html');
Route::get('/resource-kit/share/liist.html', [ResourceController::class, 'list'])->name('resource.share.list.html');
Route::get('/resource-kit/share/{resource}.html', [ResourceController::class, 'show'])->name('resource.share.show.html')->whereNumber('resource');;

Route::get('/resource-kit/video.html', [ResourceController::class, 'index'])->name('resource.video.html');
Route::get('/resource-kit/video/liist.html', [ResourceController::class, 'list'])->name('resource.video.list.html');
Route::get('/resource-kit/video/{resource}.html', [ResourceController::class, 'show'])->name('resource.video.show.html')->whereNumber('resource');;


Route::middleware(['auth', 'auth.session'])->group(function ($route) {

    $route->delete('/logout.html', [AuthController::class, 'logout'])->name('user.logout.html');

    //下载文件
    $route->get('download.html', [DownloadController::class, 'download'])->name('user.download.html');
    $route->get('preview.html', [DownloadController::class, 'preview'])->name('user.preview.html');

    $route->get('/course/{course}.html', [CourseController::class, 'show'])->name('course.details.html');
    $route->get('/course/{course}/unit/{unit}.html', [CourseController::class, 'handleUnitShow'])->name('course.unit.details.html');

    $route->get('quiz/{unit}.html', [CommonController::class, 'getQuizDetail'])->name('common.get-quiz-detail.html');
    $route->post('/course/{course}/play-record.html', [CourseController::class, 'handleSavePlayRecord'])->name('course.save-play-record.html');
    $route->post('/course/{course}/play-start.html', [CourseController::class, 'handleRecordPlayStart'])->name('course.play-start.html');
    $route->post('/course/{course}/play-end.html', [CourseController::class, 'handleRecordPlayEnd'])->name('course.play-end.html');
    $route->post('/course/{course}/quiz-answer.html', [CourseController::class, 'handleSaveQuizAnswer'])->name('course.save-quiz-answer.html');
    $route->get('/course/{course}/answered-questions.html', [CourseController::class, 'getAnsweredQuestions'])->name('course.answered-questions.html');
    $route->get('/course/{course}/quiz-statistics.html', [CourseController::class, 'getQuizStatistics'])->name('course.quiz-statistics.html');
    $route->post('/course/{course}/certificate.html', [CourseController::class, 'handleCertificate'])->name('course.handle.html');
    $route->get('/course/{course}/certificate-status.html', [CourseController::class, 'checkCertificateStatus'])->name('course.certificate-status.html');

    $route->group(['prefix' => 'user'], function ($route) {
        //修改头像
        $route->post('set-avatar.html', [ProfileController::class, 'handleSetAvatar'])->name('user.set-avatar.html');
        //删除头像
        $route->delete('remove-avatar.html', [ProfileController::class, 'handleRemoveAvatar'])->name('user.remove-avatar.html');

        $route->get('/dashboard.html', [DashboardController::class, 'index'])->name('user.dashboard.html');
        $route->get('/profile.html', [ProfileController::class, 'index'])->name('user.profile.html');
        $route->get('/course.html', [UserCourseController::class, 'index'])->name('user.course.html');
        $route->get('/course/list.html', [UserCourseController::class, 'list'])->name('user.course.list.html');
        $route->get('/certificate.html', [CertificateController::class, 'index'])->name('user.certificate.html');
        $route->get('/certificate/list.html', [CertificateController::class, 'list'])->name('user.certificate.list.html');
        $route->get('/quiz.html', [QuizController::class, 'index'])->name('user.quiz.html');
        $route->get('/quiz/list.html', [QuizController::class, 'list'])->name('user.quiz.list.html');
        $route->get('/quiz/{quiz}/result.html', [QuizController::class, 'result'])->name('user.quiz-results.html');

        $route->get('/settings.html', [SettingController::class, 'index'])->name('user.settings.html');
        $route->post('/settings.html', [SettingController::class, 'handleSetting']);

        $route->get('/change-password.html', [ChangePasswordController::class, 'index'])->name('user.change-password.html');
        $route->post('/change-password.html', [ChangePasswordController::class, 'handleChangePassword']);

        $route->post('/user/info/confirm.html', [ProfileController::class, 'handleInfoConfirm'])->name('user.info.confirm.html');
    });
});

Route::get('marker', [CommonController::class, 'marker'])->name('marker');
Route::get('404.html', [PageController::class, 'error'])->name('error');
Route::get('{page}', [PageController::class, 'index'])->name('page');
