<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class WebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson()) {
            $user = $request->user();

            if ($user && Str::contains($request->url(), ['login.html', 'register.html', 'forgot-password.html', 'reset-password.html'])) {
//                return to_route('home');
            }

            View::share('user', $user);
        }

        return $next($request);
    }
}
