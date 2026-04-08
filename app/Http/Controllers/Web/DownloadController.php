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

            $pathInfo = pathinfo($file);
            $pdf_file = ($pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '') . $pathInfo['filename'] . '.pdf';

            if (!Storage::exists($pdf_file)) {
                $this->convertImageToPdf($file, $pdf_file);
            }

            return Storage::download($file, Str::uuid() . '.pdf');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 在浏览器中直接输出 PDF
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function preview(Request $request)
    {
        if (!$request->hasValidSignature(false)) {
            abort(401);
        }

        try {
            $file = $request->query('file');
            if (!Storage::exists($file)) {
                throw new \Exception(__('文件不存在'));
            }

            $pathInfo = pathinfo($file);
            $pdf_file = ($pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '') . $pathInfo['filename'] . '.pdf';

            if (!Storage::exists($pdf_file)) {
                $this->convertImageToPdf($file, $pdf_file);
            }

            $full_pdf_path = Storage::path($pdf_file);
            $filename = Str::uuid() . '.pdf';

            return response()->file($full_pdf_path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 将图片转换为 PDF
     *
     * @param string $image_path 图片路径（Storage 相对路径）
     * @param string $pdf_path PDF 路径（Storage 相对路径）
     * @throws \Exception
     */
    private function convertImageToPdf(string $image_path, string $pdf_path): void
    {
        // 检查是否安装了 Imagick 扩展
        if (!extension_loaded('imagick')) {
            throw new \Exception(__('需要安装 Imagick 扩展才能将图片转换为 PDF'));
        }

        try {
            // 获取图片的完整路径
            $full_image_path = Storage::path($image_path);

            // 创建 Imagick 对象
            $imagick = new \Imagick($full_image_path);

            // 设置图片格式为 PDF
            $imagick->setImageFormat('pdf');

            // 确保目录存在
            $pdf_dir = dirname(Storage::path($pdf_path));
            if (!is_dir($pdf_dir)) {
                mkdir($pdf_dir, 0755, true);
            }

            // 保存 PDF 文件
            $imagick->writeImage(Storage::path($pdf_path));

            // 释放资源
            $imagick->clear();
            $imagick->destroy();
        } catch (\Exception $e) {
            throw new \Exception(__('图片转换为 PDF 失败: ') . $e->getMessage());
        }
    }
}
