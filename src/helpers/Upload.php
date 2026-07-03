<?php

declare(strict_types=1);

namespace App\Helpers;

final class Upload
{
    public static function image(array $file, string $targetDir): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $ext = pathinfo((string) $file['name'], PATHINFO_EXTENSION);
        $name = uniqid('img_', true) . '.' . strtolower($ext);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $target = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
        if (!move_uploaded_file((string) $file['tmp_name'], $target)) {
            return null;
        }

        return $name;
    }
}
