<?php

namespace App\Services;

class ImageService
{
    private const MAX_WIDTH = 1500;

    private const JPEG_QUALITY = 85;

    public function optimize(string $sourcePath, string $destinationPath): void
    {
        [$width, $height, $type] = getimagesize($sourcePath);

        $source = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($sourcePath),
            default => imagecreatefromjpeg($sourcePath),
        };

        if ($width > self::MAX_WIDTH) {
            $newWidth = self::MAX_WIDTH;
            $newHeight = (int) round($height * (self::MAX_WIDTH / $width));
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        $dir = dirname($destinationPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        imagejpeg($source, $destinationPath, self::JPEG_QUALITY);
        imagedestroy($source);
    }
}
