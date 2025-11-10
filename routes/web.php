<?php

use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\IndexController;
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

Route::get('/', [IndexController::class, 'index']);
Route::get('/index.html', [IndexController::class, 'index'])->name('index.html');
Route::get('/login.html', [LoginController::class, 'index'])->name('login.html');
Route::post('/login.html', [LoginController::class, 'handleLogin']);
Route::get('/register.html', [RegisterController::class, 'index'])->name('register.html');
Route::post('/register.html', [RegisterController::class, 'handleRegister']);
Route::get('/forgot-password.html', [ForgotPasswordController::class, 'index'])->name('forgot-password.html');
Route::post('/forgot-password.html', [ForgotPasswordController::class, 'handleForgotPassword']);
Route::get('/reset-password.html', [ResetPasswordController::class, 'index'])->name('reset-password.html');
Route::post('/reset-password.html', [ResetPasswordController::class, 'handleResetPassword']);

Route::middleware(['auth', 'auth.session'])->group(function ($route) {

    $route->get('/logout.html', [UserController::class, 'logout'])->name('logout.html');

    Route::get('/dashboard.html', [DashboardController::class, 'index'])->name('dashboard.html');
});
