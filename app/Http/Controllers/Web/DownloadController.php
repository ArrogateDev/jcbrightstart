<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function download(Request $request)
    {
        if (!$request->hasValidSignature(false)) {
            abort(401);
        }
        try {
            $file = $request->query('file');
            if (!Storage::exists($file)) {
                throw new \Exception(__('文件不存在'));
            }

            $path = Str::beforeLast($file, '/');

            print_r($path);
//            return Storage::download($file);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
