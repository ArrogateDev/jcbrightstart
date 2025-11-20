<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // 如果是 admin guard，重定向到管理员登录页
        if ($request->is('admin/*')) {
            return route('admin.login.html');
        }
        
        return null;
    }
}
