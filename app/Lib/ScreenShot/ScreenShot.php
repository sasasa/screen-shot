<?php
namespace App\Lib\ScreenShot;

class ScreenShot {

    /**
     * Get a screenshot by specifying the URL
     * @param string $url
     * @param string|null $outputFile
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string|false
     */
    public static function getScreenshot(string $url, string $outputFile = null): string {
        $outputFile = $outputFile ?? tempnam(storage_path(), 'screenshot'). '.jpg';
        $command = "xvfb-run --server-args='-screen 0, 1024x768x24' cutycapt --delay=6000 --url=\"{$url}\" --out={$outputFile} --min-width=1280";
        @exec($command);
        return file_get_contents($outputFile);
    }

    /**
     * Take a monotone screenshot
     */
    public static function getMonotoneScreenshot(string $url, string $outputFile = null): string {
        $outputFile = $outputFile ?? tempnam(storage_path(), 'screenshot'). '.jpg';
        $command = "xvfb-run --server-args='-screen 0, 1024x768x24' cutycapt --delay=6000 --url={$url} --out={$outputFile} --min-width=1280 --javascript=off --plugins=off --private-browsing=on --insecure=on --auto-load-images=off --print-backgrounds=off --zoom-factor=1 --min-width=1280";
        @exec($command);
        return file_get_contents($outputFile);
    }
}