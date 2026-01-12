<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\Course\Course;
use App\Models\User\UserCourseCertificate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCourseCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private UserCourseCertificate $log;

    /**
     * Create a new job instance.
     */
    public function __construct(UserCourseCertificate $log)
    {
        $this->log = $log;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $log = $this->log;

        try {

            $certificate = Certificate::query()->find($log->certificate_id);

            $name = $log->name;

            $path = $this->handleCreateCertificateImage($certificate, $name, $log->user_id, date('m/d/y'));
            $log->file = $path;
            $log->status = UserCourseCertificate::STATUS_GENERATED;
            if ($log->save() === false) {
                throw new \Exception(__('log:failed'));
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 生成证书图片
     */
    private function handleCreateCertificateImage(Certificate $certificate, string $name, int $user_id, string $date): string
    {
        $templatePath = storage_path('app/public/' . $certificate->getRawOriginal('path'));
        echo $templatePath;

        if (!file_exists($templatePath)) {
            throw new \Exception(__('证书模板图片不存在'));
        }

        // 获取图片信息
        $imageInfo = getimagesize($templatePath);
        $imageType = $imageInfo[2];

        // 创建画布
        $width = $certificate->width;
        $height = $certificate->height;
        $canvas = imagecreatetruecolor($width, $height);

        // 设置背景为白色
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        // 加载模板图片
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $template = imagecreatefromjpeg($templatePath);
                break;
            case IMAGETYPE_PNG:
                $template = imagecreatefrompng($templatePath);
                break;
            case IMAGETYPE_GIF:
                $template = imagecreatefromgif($templatePath);
                break;
            default:
                throw new \Exception(__('不支持的图片格式'));
        }

        // 将模板图片复制到画布
        imagecopyresampled($canvas, $template, 0, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]);

        // 添加姓名文本
        if ($certificate->name_config) {
            $this->addTextToImage(
                $canvas,
                $name,
                $certificate->name_config
            );
        }

        // 添加日期文本
        if ($certificate->date_config) {
            $this->addTextToImage(
                $canvas,
                $date,
                $certificate->date_config
            );
        }

        // 保存生成的证书
        $file_path = 'certificates/users/' . $user_id . '/';
        $file_name = uniqid() . '.png';
        $fullPath = storage_path('app/public/' . $file_path . $file_name);

        // 确保目录存在
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        imagepng($canvas, $fullPath);

        // 释放内存
        imagedestroy($canvas);
        imagedestroy($template);

        return $file_path . $file_name;
    }

    /**
     * 在图片上添加文本
     */
    private function addTextToImage($canvas, string $text, array $config)
    {
        // 解析颜色（支持hex和rgb）
        $color = $this->parseColor($config['fill'] ?? '#000000');
        $textColor = imagecolorallocate($canvas, $color['r'], $color['g'], $color['b']);

        // 字体大小
        $fontSize = $config['fontSize'] ?? 24;

        // 位置
        $x = $config['left'] ?? 0;
        $y = $config['top'] ?? 0;

        // 文本对齐方式
        $textAlign = $config['textAlign'] ?? 'center';
        $originX = $config['originX'] ?? 'center';
        $originY = $config['originY'] ?? 'center';

        // 尝试使用TTF字体
        $fontPath = $this->getFontPath();

        if ($fontPath && function_exists('imagettftext')) {
            // 使用TTF字体
            $angle = 0;

            // 计算文本边界框
            $bbox = imagettfbbox($fontSize, $angle, $fontPath, $text);
            $textWidth = abs($bbox[4] - $bbox[0]);
            $textHeight = abs($bbox[5] - $bbox[1]);

            // 根据originX调整X坐标
            if ($originX === 'center' || $textAlign === 'center') {
                $x = $x - ($textWidth / 2);
            } elseif ($originX === 'right' || $textAlign === 'right') {
                $x = $x - $textWidth;
            }

            // 根据originY调整Y坐标
            if ($originY === 'center') {
                $y = $y + ($textHeight / 2);
            } elseif ($originY === 'bottom') {
                $y = $y + $textHeight;
            }

            // 添加文本
            imagettftext($canvas, $fontSize, $angle, (int)$x, (int)$y, $textColor, $fontPath, $text);
        } else {
            // 使用内置字体（降级方案）
            $font = 5; // 最大内置字体

            // 计算文本宽度和高度
            $textWidth = imagefontwidth($font) * strlen($text);
            $textHeight = imagefontheight($font);

            // 根据对齐方式调整X坐标
            if ($textAlign === 'center' || $originX === 'center') {
                $x = $x - ($textWidth / 2);
            } elseif ($textAlign === 'right' || $originX === 'right') {
                $x = $x - $textWidth;
            }

            // 根据originY调整Y坐标
            if ($originY === 'center') {
                $y = $y + ($textHeight / 2);
            } elseif ($originY === 'bottom') {
                $y = $y + $textHeight;
            }

            // 添加文本
            imagestring($canvas, $font, (int)$x, (int)$y, $text, $textColor);
        }
    }

    /**
     * 获取字体文件路径
     */
    private function getFontPath(): ?string
    {

        $fontPath = storage_path('app/public/fonts/PingFangSC-Regular.ttf');
        // 如果字体文件不存在，返回null使用内置字体
        if (!file_exists($fontPath)) {
            return null;
        }

        return $fontPath;
    }

    /**
     * 解析颜色值
     */
    private function parseColor(string $color): array
    {
        // 如果是hex颜色
        if (strpos($color, '#') === 0) {
            $color = substr($color, 1);
            if (strlen($color) === 3) {
                $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
            }
            return [
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2)),
            ];
        }

        // 默认黑色
        return ['r' => 0, 'g' => 0, 'b' => 0];
    }
}
