<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{

    private const SUPPORTED_LOCALES = ['en', 'zh_CN', 'zh_HK'];

    /**
     * 切换语言
     *
     * @param Request $request
     * @param string $locale
     * @return RedirectResponse
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (!in_array($locale, self::SUPPORTED_LOCALES)) {
            $locale = config('app.locale', 'zh_HK');
        }

        session(['locale' => $locale]);
        App::setLocale($locale);

        $cookie = Cookie::make('locale', $locale, 60 * 24 * 365);

        return redirect()->back()->with('success', __('语言切换成功'))->withCookie($cookie);
    }
}






