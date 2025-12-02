<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseCode;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificateRequest;
use App\Models\Certificate;
use App\Tools\FileTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * 证书列表页
     */
    public function index()
    {
        return view('admin.certificate.list');
    }

    /**
     * 证书列表
     */
    public function list(Request $request)
    {
        $keyword = $request->query('keyword');

        $list = Certificate::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(limit_page());

        return $this->responseSuccess($list);
    }

    /**
     * @param CertificateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function store(CertificateRequest $request)
    {
        $user_id = $request->user('admin')->id;
        if (!(($lock = Cache::lock("submit_certificate_store_lock:$user_id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'name_config', 'date_config', 'width', 'height']);

        try {

            $file_path = FileTool::existsAndMake('certificates');

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $file_name = uniqid() . '.' . $extension;
            Storage::putFileAs($file_path, $file, $file_name);

            $certificate = new Certificate();
            foreach ($inputs as $key => $value) {
                $certificate->$key = $value;
            }
            $certificate->path = $file_path . $file_name;
            if ($certificate->save() === false) {
                throw new \Exception('certificate:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param CertificateRequest $request
     * @param Certificate $certificate
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function update(CertificateRequest $request, Certificate $certificate)
    {
        if (!(($lock = Cache::lock("submit_certificate_update_lock:$certificate->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        $inputs = $request->only(['name', 'name_config', 'date_config', 'width', 'height']);

        try {

            $file = $request->file('image');
            if ($file) {
                $file_path = FileTool::existsAndMake('certificates');
                $extension = $file->getClientOriginalExtension();
                $file_name = uniqid() . '.' . $extension;
                Storage::putFileAs($file_path, $file, $file_name);

                $old_path = $certificate->getRawOriginal('path');
                FileTool::existsAnddelete($old_path);

                $certificate->path = $file_path . $file_name;
            }

            foreach ($inputs as $key => $value) {
                $certificate->$key = $value;
            }
            if ($certificate->save() === false) {
                throw new \Exception('certificate:failed', ResponseCode::SERVER_ERR);
            }

            return $this->responseSuccess(null, __('成功'));
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error($e);
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

    /**
     * @param Certificate $certificate
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function destroy(Certificate $certificate)
    {
        if (!(($lock = Cache::lock("submit_certificate_destroy_lock:$certificate->id", 360))->get())) {
            throw new ApiException(__('Frequent operation, please try again later'), ResponseCode::FREQUENTLY);
        }

        // 请求结束后关闭锁
        def($_Context, function () use (&$lock) {
            $lock->release();
        });

        try {

            $old_path = $certificate->getRawOriginal('path');
            FileTool::existsAnddelete($old_path);

            $certificate->delete();

            return $this->responseSuccess(null, __('成功'));
        } catch (\Exception $e) {
            throw new ApiException(__('失败'), ResponseCode::SERVER_ERR);
        }
    }

//    /**
//     * 生成用户证书
//     */
//    public function generateUserCertificate(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'certificate_id' => 'required|exists:certificates,id',
//            'user_id' => 'required|exists:users,id',
//            'name' => 'required|string|max:255',
//            'date' => 'required|string|max:255',
//        ]);
//
//        if ($validator->fails()) {
//            throw new ApiException($validator->errors()->first(), ResponseCode::PARAM_ERR);
//        }
//
//        try {
//            $certificate = Certificate::findOrFail($request->input('certificate_id'));
//
//            // 生成证书图片
//            $imagePath = $this->generateCertificateImage(
//                $certificate,
//                $request->input('name'),
//                $request->input('date')
//            );
//
//            // 保存用户证书记录
//            $userCertificate = \App\Models\UserCertificate::query()->create([
//                'user_id' => $request->input('user_id'),
//                'certificate_id' => $certificate->id,
//                'name' => $request->input('name'),
//                'date' => $request->input('date'),
//                'image_path' => $imagePath,
//            ]);
//
//            return $this->responseSuccess($userCertificate, __('证书生成成功'));
//        } catch (\Exception $e) {
//            Log::error('生成用户证书失败: ' . $e->getMessage());
//            throw new ApiException(__('生成失败'), ResponseCode::SERVER_ERR);
//        }
//    }
//
//    /**
//     * 生成证书图片
//     */
//    private function generateCertificateImage(Certificate $certificate, string $name, string $date): string
//    {
//        $templatePath = storage_path('app/' . $certificate->image_path);
//
//        if (!file_exists($templatePath)) {
//            throw new ApiException(__('证书模板图片不存在'), ResponseCode::PARAM_ERR);
//        }
//
//        // 获取图片信息
//        $imageInfo = getimagesize($templatePath);
//        $imageType = $imageInfo[2];
//
//        // 创建画布
//        $width = $certificate->width;
//        $height = $certificate->height;
//        $canvas = imagecreatetruecolor($width, $height);
//
//        // 设置背景为白色
//        $white = imagecolorallocate($canvas, 255, 255, 255);
//        imagefill($canvas, 0, 0, $white);
//
//        // 加载模板图片
//        switch ($imageType) {
//            case IMAGETYPE_JPEG:
//                $template = imagecreatefromjpeg($templatePath);
//                break;
//            case IMAGETYPE_PNG:
//                $template = imagecreatefrompng($templatePath);
//                break;
//            case IMAGETYPE_GIF:
//                $template = imagecreatefromgif($templatePath);
//                break;
//            default:
//                throw new ApiException(__('不支持的图片格式'), ResponseCode::PARAM_ERR);
//        }
//
//        // 将模板图片复制到画布
//        imagecopyresampled($canvas, $template, 0, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]);
//
//        // 添加姓名文本
//        if ($certificate->name_text_config) {
//            $this->addTextToImage(
//                $canvas,
//                $name,
//                $certificate->name_text_config
//            );
//        }
//
//        // 添加日期文本
//        if ($certificate->date_text_config) {
//            $this->addTextToImage(
//                $canvas,
//                $date,
//                $certificate->date_text_config
//            );
//        }
//
//        // 保存生成的证书
//        $file_path = 'certificates/users/';
//        $file_name = uniqid() . '.png';
//        $fullPath = storage_path('app/' . $file_path . $file_name);
//
//        // 确保目录存在
//        if (!is_dir(dirname($fullPath))) {
//            mkdir(dirname($fullPath), 0755, true);
//        }
//
//        imagepng($canvas, $fullPath);
//
//        // 释放内存
//        imagedestroy($canvas);
//        imagedestroy($template);
//
//        return $file_path . $file_name;
//    }
//
//    /**
//     * 在图片上添加文本
//     */
//    private function addTextToImage($canvas, string $text, array $config)
//    {
//        // 解析颜色（支持hex和rgb）
//        $color = $this->parseColor($config['fill'] ?? '#000000');
//        $textColor = imagecolorallocate($canvas, $color['r'], $color['g'], $color['b']);
//
//        // 字体大小
//        $fontSize = $config['fontSize'] ?? 24;
//
//        // 位置
//        $x = $config['left'] ?? 0;
//        $y = $config['top'] ?? 0;
//
//        // 文本对齐方式
//        $textAlign = $config['textAlign'] ?? 'center';
//        $originX = $config['originX'] ?? 'center';
//        $originY = $config['originY'] ?? 'center';
//
//        // 尝试使用TTF字体
//        $fontPath = $this->getFontPath($config['fontFamily'] ?? 'Arial');
//
//        if ($fontPath && function_exists('imagettftext')) {
//            // 使用TTF字体
//            $angle = 0;
//
//            // 计算文本边界框
//            $bbox = imagettfbbox($fontSize, $angle, $fontPath, $text);
//            $textWidth = abs($bbox[4] - $bbox[0]);
//            $textHeight = abs($bbox[5] - $bbox[1]);
//
//            // 根据originX调整X坐标
//            if ($originX === 'center' || $textAlign === 'center') {
//                $x = $x - ($textWidth / 2);
//            } elseif ($originX === 'right' || $textAlign === 'right') {
//                $x = $x - $textWidth;
//            }
//
//            // 根据originY调整Y坐标
//            if ($originY === 'center') {
//                $y = $y + ($textHeight / 2);
//            } elseif ($originY === 'bottom') {
//                $y = $y + $textHeight;
//            }
//
//            // 添加文本
//            imagettftext($canvas, $fontSize, $angle, (int)$x, (int)$y, $textColor, $fontPath, $text);
//        } else {
//            // 使用内置字体（降级方案）
//            $font = 5; // 最大内置字体
//
//            // 计算文本宽度和高度
//            $textWidth = imagefontwidth($font) * strlen($text);
//            $textHeight = imagefontheight($font);
//
//            // 根据对齐方式调整X坐标
//            if ($textAlign === 'center' || $originX === 'center') {
//                $x = $x - ($textWidth / 2);
//            } elseif ($textAlign === 'right' || $originX === 'right') {
//                $x = $x - $textWidth;
//            }
//
//            // 根据originY调整Y坐标
//            if ($originY === 'center') {
//                $y = $y + ($textHeight / 2);
//            } elseif ($originY === 'bottom') {
//                $y = $y + $textHeight;
//            }
//
//            // 添加文本
//            imagestring($canvas, $font, (int)$x, (int)$y, $text, $textColor);
//        }
//    }
//
//    /**
//     * 获取字体文件路径
//     */
//    private function getFontPath(string $fontFamily): ?string
//    {
//        // 字体文件映射（需要将字体文件放在storage/fonts目录下）
//        $fontMap = [
//            'Arial' => 'arial.ttf',
//            'Times New Roman' => 'times.ttf',
//            'Courier New' => 'courier.ttf',
//            'Verdana' => 'verdana.ttf',
//            'Georgia' => 'georgia.ttf',
//            'Comic Sans MS' => 'comic.ttf',
//        ];
//
//        $fontFile = $fontMap[$fontFamily] ?? 'arial.ttf';
//        $fontPath = storage_path('fonts/' . $fontFile);
//
//        // 如果字体文件不存在，返回null使用内置字体
//        if (!file_exists($fontPath)) {
//            return null;
//        }
//
//        return $fontPath;
//    }
//
//    /**
//     * 解析颜色值
//     */
//    private function parseColor(string $color): array
//    {
//        // 如果是hex颜色
//        if (strpos($color, '#') === 0) {
//            $color = substr($color, 1);
//            if (strlen($color) === 3) {
//                $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
//            }
//            return [
//                'r' => hexdec(substr($color, 0, 2)),
//                'g' => hexdec(substr($color, 2, 2)),
//                'b' => hexdec(substr($color, 4, 2)),
//            ];
//        }
//
//        // 默认黑色
//        return ['r' => 0, 'g' => 0, 'b' => 0];
//    }
}
