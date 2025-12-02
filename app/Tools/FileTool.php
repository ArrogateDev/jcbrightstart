<?php

namespace App\Tools;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileTool
{
    public static function existsAndMake($folder)
    {
        $date = Carbon::now()->format('Ymd');
        $file_path = sprintf('files/%s/%s/', $folder, $date);
        if (!Storage::exists($file_path)) {
            Storage::makeDirectory($file_path);
        }
        return $file_path;
    }

    public static function existsAnddelete($file)
    {
        if ($file && Storage::exists($file)) {
            Storage::delete($file);
        }
    }
}
