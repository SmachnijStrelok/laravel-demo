<?php


namespace App\Helpers;


class DownloadHelper
{
    public static function downloadFile($filePath, $fileName){
        $mime = mime_content_type($filePath);
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: ' . ($mime ?? 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        readfile($filePath);
    }

}
