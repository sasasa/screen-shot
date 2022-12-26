<?php
declare(strict_types=1);
namespace App\Services\Presenters;

use App\Lib\SenseOfColor\SenseOfColor;

class ColorService
{
    public function isTextColorWhite(?string $hexColor): bool {
        if (is_null($hexColor)) {
            return false;
        }
        $rgb = SenseOfColor::hex2rgb($hexColor);
        return SenseOfColor::getBrightness($rgb[0], $rgb[1], $rgb[2]) < 125;
    }
}
