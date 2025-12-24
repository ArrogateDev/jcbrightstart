<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

        return redirect()->back()->with('success', __('Language switched successfully'));
    }
}

