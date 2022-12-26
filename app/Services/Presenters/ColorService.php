<?php
declare(strict_types=1);
namespace App\Services\Presenters;

use App\Lib\SenseOfColor\SenseOfColor;

class ColorService
{
    /**
     * Get brightness from rgb
     */
    private function getBrightness(int $r, int $g, int $b): float {
        return round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
    }

    public function isTextColorWhite(?string $hexColor): bool {
        if (is_null($hexColor)) {
            return false;
        }
        $rgb = SenseOfColor::hex2rgb($hexColor);
        return $this->getBrightness($rgb[0], $rgb[1], $rgb[2]) < 125;
    }
}
