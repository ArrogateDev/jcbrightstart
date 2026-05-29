<?php

namespace App\Http\Middleware;

use App\Models\Manage\Authority;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class AdminMiddleware
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
        if ($request->expectsJson()) return $next($request);
        $locale = $request->cookie('locale') ?? $request->session()->get('locale');
        $locale = 'zh_HK';
        if ($locale && in_array($locale, ['en', 'zh_CN', 'zh_HK'])) {
            App::setLocale($locale);
            if ($request->cookie('locale') && !$request->session()->has('locale')) {
                session(['locale' => $locale]);
            }
        }

        $user = $request->user('admin');

        if ($user && Str::contains($request->url(), ['login.html'])) {
            return to_route('admin.dashboard.html');
        }

        if ($user) {
            Cache::tags(['MENUS'])->flush();
            $role = $user->role;
            $role_id = $role->id;
            $menus = Cache::tags(['MENUS', 'ROLE:' . $role->id])->rememberForever('MENU_LIST', function () use ($role, $role_id, $user) {

                $authority = $role_id === 1 ? Authority::query()->whereIn('type', [Authority::MENU_TYPE, Authority::GPS_TYPE])->get() : $role->permissions;

                $authority = authority_format($authority->toArray());
                $menus = [];
                foreach ($authority as $key => $value) {
                    $menus[$key]['name'] = $value['name'];
                    foreach ($value['children'] as $k => $v) {
                        $menus[$key]['children'][$k]['icon'] = $v['icon'] ?? '';
                        $menus[$key]['children'][$k]['name'] = $v['name'];
                        $snake = Str::snake($v['alias'], '-');
                        $url = Str::replace('-list', '.html', $snake);
                        $menus[$key]['children'][$k]['active'] = Str::replace('-list', '', $snake);
                        $menus[$key]['children'][$k]['url'] = route('admin.' . $url);
                    }
                }
                return $menus;
            });

            View::share('user', $user);
            View::share('menus', $menus);
        }

        $title = __('赛马会幼儿「喜步」计划');

        View::share('title', $title);

        return $next($request);
    }
}
