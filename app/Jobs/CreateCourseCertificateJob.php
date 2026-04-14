<?php

namespace App\Jobs;

use App\Models\Certificate;
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

            $name = $log->full_name;

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
        // Prefer Imagick when available (handles large images more reliably than GD).
        if (class_exists(\Imagick::class)) {
            return $this->handleCreateCertificateImageByImagick($certificate, $name, $user_id, $date);
        }

        $template_path = storage_path('app/public/' . $certificate->getRawOriginal('path'));

        if (!file_exists($template_path)) {
            throw new \Exception(__('证书模板图片不存在'));
        }

        // 获取图片信息
        $image_info = getimagesize($template_path);
        $image_type = $image_info[2];

        // 加载模板图片
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $template = imagecreatefromjpeg($template_path);
                break;
            case IMAGETYPE_PNG:
                $template = imagecreatefrompng($template_path);
                break;
            case IMAGETYPE_GIF:
                $template = imagecreatefromgif($template_path);
                break;
            default:
                throw new \Exception(__('不支持的图片格式'));
        }

        if (!$template) {
            throw new \Exception(__('证书模板图片加载失败'));
        }

        // Prefer reusing the template as the canvas to avoid holding 2 large bitmaps in memory.
        $target_width = (int)($certificate->width ?: $image_info[0]);
        $target_height = (int)($certificate->height ?: $image_info[1]);

        if ($target_width <= 0 || $target_height <= 0) {
            imagedestroy($template);
            throw new \Exception(__('证书尺寸无效'));
        }

        if ($target_width === (int)$image_info[0] && $target_height === (int)$image_info[1]) {
            $canvas = $template;
            $template = null;
        } else {
            $canvas = imagecreatetruecolor($target_width, $target_height);
            if (!$canvas) {
                imagedestroy($template);
                throw new \Exception(__('创建画布失败'));
            }

            // 设置背景为白色
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefill($canvas, 0, 0, $white);

            imagecopyresampled($canvas, $template, 0, 0, 0, 0, $target_width, $target_height, (int)$image_info[0], (int)$image_info[1]);
            imagedestroy($template);
            $template = null;
        }

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
        $full_path = storage_path('app/public/' . $file_path . $file_name);

        // 确保目录存在
        if (!is_dir(dirname($full_path))) {
            mkdir(dirname($full_path), 0755, true);
        }

        imagepng($canvas, $full_path);

        // 释放内存
        imagedestroy($canvas);
        if ($template) {
            imagedestroy($template);
        }

        return $file_path . $file_name;
    }

    /**
     * 使用 Imagick 生成证书图片（更适合大图）
     */
    private function handleCreateCertificateImageByImagick(Certificate $certificate, string $name, int $user_id, string $date): string
    {
        $template_path = storage_path('app/public/' . $certificate->getRawOriginal('path'));

        if (!file_exists($template_path)) {
            throw new \Exception(__('证书模板图片不存在'));
        }

        $image = new \Imagick();
        $image->readImage($template_path);

        $target_width = $image->getImageWidth();
        $target_height = $image->getImageHeight();
        $design_width = (float)($certificate->width ?: $target_width);
        $design_height = (float)($certificate->height ?: $target_height);
        $scale_x = $design_width > 0 ? ($target_width / $design_width) : 1.0;
        $scale_y = $design_height > 0 ? ($target_height / $design_height) : 1.0;

        if ($target_width <= 0 || $target_height <= 0) {
            $image->clear();
            $image->destroy();
            throw new \Exception(__('证书尺寸无效'));
        }

        if ($image->getImageWidth() !== $target_width || $image->getImageHeight() !== $target_height) {
            $image->resizeImage($target_width, $target_height, \Imagick::FILTER_LANCZOS, 1);
        }

        $image->setImageFormat('png');

        if ($certificate->name_config) {
            $this->addTextToImageByImagick($image, $name, $certificate->name_config, $scale_x, $scale_y, $this->getNameFontPath($name));
        }

        if ($certificate->date_config) {
            $this->addTextToImageByImagick($image, $date, $certificate->date_config, $scale_x, $scale_y);
        }

        $file_path = 'certificates/users/' . $user_id . '/';
        $file_name = uniqid() . '.png';
        $full_path = storage_path('app/public/' . $file_path . $file_name);

        if (!is_dir(dirname($full_path))) {
            mkdir(dirname($full_path), 0755, true);
        }

        $image->writeImage($full_path);
        $image->clear();
        $image->destroy();

        return $file_path . $file_name;
    }

    private function addTextToImageByImagick(\Imagick $image, string $text, array $config, float $scale_x = 1.0, float $scale_y = 1.0, ?string $font_path = null): void
    {
        $draw = new \ImagickDraw();

        $font_path = $font_path ?: $this->getFontPath();
        if ($font_path) {
            $draw->setFont($font_path);
        }

        $font_size = (float)($config['fontSize'] ?? 24) * $scale_y;
        $draw->setFontSize($font_size);

        $color = $this->parseColor($config['fill'] ?? '#000000');
        $draw->setFillColor(new \ImagickPixel(sprintf('rgb(%d,%d,%d)', $color['r'], $color['g'], $color['b'])));

        $x = (float)($config['left'] ?? 0) * $scale_x;
        $y = (float)($config['top'] ?? 0) * $scale_y;

        $text_align = $config['textAlign'] ?? 'center';
        $origin_y = $config['originY'] ?? 'center';

        $align = match ($text_align) {
            'right' => \Imagick::ALIGN_RIGHT,
            'left' => \Imagick::ALIGN_LEFT,
            default => \Imagick::ALIGN_CENTER,
        };
        $draw->setTextAlignment($align);

        $metrics = $image->queryFontMetrics($draw, $text);
        $text_height = (float)($metrics['textHeight'] ?? 0);

        // Imagick uses baseline Y.
        if ($origin_y === 'center') {
            $y = $y + ($text_height / 2);
        } elseif ($origin_y === 'bottom') {
            $y = $y + $text_height;
        } else {
            $y = $y + $text_height;
        }

        $image->annotateImage($draw, $x, $y, 0, $text);
    }

    /**
     * 在图片上添加文本
     */
    private function addTextToImage($canvas, string $text, array $config)
    {
        // 解析颜色（支持hex和rgb）
        $color = $this->parseColor($config['fill'] ?? '#000000');
        $text_color = imagecolorallocate($canvas, $color['r'], $color['g'], $color['b']);

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
        $font_path = $this->getNameFontPath($text) ?: $this->getFontPath();

        if ($font_path && function_exists('imagettftext')) {
            // 使用TTF字体
            $angle = 0;

            // 计算文本边界框
            $bbox = imagettfbbox($fontSize, $angle, $font_path, $text);
            $text_width = abs($bbox[4] - $bbox[0]);
            $text_height = abs($bbox[5] - $bbox[1]);

            // 根据originX调整X坐标
            if ($originX === 'center' || $textAlign === 'center') {
                $x = $x - ($text_width / 2);
            } elseif ($originX === 'right' || $textAlign === 'right') {
                $x = $x - $text_width;
            }

            // 根据originY调整Y坐标
            if ($originY === 'center') {
                $y = $y + ($text_height / 2);
            } elseif ($originY === 'bottom') {
                $y = $y + $text_height;
            }

            // 添加文本
            imagettftext($canvas, $fontSize, $angle, (int)$x, (int)$y, $text_color, $font_path, $text);
        } else {
            // 使用内置字体（降级方案）
            $font = 5; // 最大内置字体

            // 计算文本宽度和高度
            $text_width = imagefontwidth($font) * strlen($text);
            $text_height = imagefontheight($font);

            // 根据对齐方式调整X坐标
            if ($textAlign === 'center' || $originX === 'center') {
                $x = $x - ($text_width / 2);
            } elseif ($textAlign === 'right' || $originX === 'right') {
                $x = $x - $text_width;
            }

            // 根据originY调整Y坐标
            if ($originY === 'center') {
                $y = $y + ($text_height / 2);
            } elseif ($originY === 'bottom') {
                $y = $y + $text_height;
            }

            // 添加文本
            imagestring($canvas, $font, (int)$x, (int)$y, $text, $text_color);
        }
    }

    /**
     * 根据姓名获取字体文件路径（中文/英文）
     */
    private function getNameFontPath(string $name): ?string
    {
        $is_chinese = preg_match('/[\x{4e00}-\x{9fff}]/u', $name) === 1;

        $font_path = $is_chinese
            ? storage_path('app/public/fonts/simsun.ttc')
            : storage_path('app/public/fonts/Baskerville-Regular-6.ttf');

        if (!file_exists($font_path)) {
            return null;
        }

        return $font_path;
    }

    /**
     * 获取默认字体文件路径
     */
    private function getFontPath(): ?string
    {
        $font_path = storage_path('app/public/fonts/PingFangSC-Regular.ttf');

        // 如果字体文件不存在，返回null使用内置字体
        if (!file_exists($font_path)) {
            return null;
        }

        return $font_path;
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
