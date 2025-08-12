<?php

use Illuminate\Support\Str;

function base64FileUpload($file, $path, $originalName = null)
{
    $mimeInfo = explode('/', mime_content_type($file));
    $extension = end($mimeInfo);
    $filename = Str::uuid().time().'.'.$extension;

    if ($originalName) {
        $tmp = explode('.', $originalName);
        $filename = Str::slug($tmp[0]).'.'.end($tmp);
    }

    $sign = explode('base64,', $file);
    $sign = end($sign);
    $sign = str_replace(' ', '+', $sign);

    createFolder($path);

    $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));
    $filePath = $path.$filename;

    file_put_contents($filePath, $fileData);
    $fileSize = round(filesize($filePath) / (1024 * 1024), 2);

    return [
        'name' => $filename,
        'size' => $fileSize,
    ];
}

function createFolder($path, $permission = 0777): void
{
    if (! is_dir($path)) {
        mkdir($path, $permission, true);
    }
}

function fileToBase64($filePath)
{
    if (! file_exists($filePath)) {
        throw new Exception("File not found: $filePath");
    }

    $imageData = file_get_contents($filePath);

    $mimeType = mime_content_type($filePath);

    $base64 = 'data:'.$mimeType.';base64,'.base64_encode($filePath);

    return $base64;
}

function getFileNameFromPath($filePath): string
{
    return pathinfo($filePath, PATHINFO_FILENAME);
}
