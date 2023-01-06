<?php
declare(strict_types=1);

namespace App\Lib\SenseOfColor;

use function PHPUnit\Framework\isNull;

final class SenseOfColor
{
    public function __construct(private string $file){}

    /**
     * Get the brightest and darkest color in the image
     *  @return string
     */
    public function getBestColor(): array {
        $image = imagecreatefromstring($this->file);
        $width = imagesx($image);
        $height = imagesy($image);
        $brightestColor = 0;
        $brightestColors = [
            'red' => 0,
            'green' => 0,
            'blue' => 0
        ];
        $darkestColor = 255 + 255 + 255;
        $darkestColors = [
            'red' => 255,
            'green' => 255,
            'blue' => 255
        ];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $rgb);
                if($brightestColor < $colors['red'] + $colors['green'] + $colors['blue']) {
                    $brightestColor = $colors['red'] + $colors['green'] + $colors['blue'];
                    $brightestColors = $colors;
                    // dump($brightestColors);
                }
                if($darkestColor > $colors['red'] + $colors['green'] + $colors['blue']) {
                    $darkestColor = $colors['red'] + $colors['green'] + $colors['blue'];
                    $darkestColors = $colors;
                    // dump($darkestColors);
                }
            }
        }
        return [
            str_pad(dechex($brightestColors['red']), 2, '0', STR_PAD_LEFT).str_pad(dechex($brightestColors['green']), 2, '0', STR_PAD_LEFT).str_pad(dechex($brightestColors['blue']), 2, '0', STR_PAD_LEFT),
            str_pad(dechex($darkestColors['red']), 2, '0', STR_PAD_LEFT).str_pad(dechex($darkestColors['green']), 2, '0', STR_PAD_LEFT).str_pad(dechex($darkestColors['blue']), 2, '0', STR_PAD_LEFT),
        ];
    }

    /**
     * Get the brightest color in the image
     *  @return string
     */
    public function getBrightestColor(): string {
        $image = imagecreatefromstring($this->file);
        $width = imagesx($image);
        $height = imagesy($image);
        $brightestColor = 0;
        $brightestColors = [
            'red' => 0,
            'green' => 0,
            'blue' => 0
        ];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $rgb);
                if($brightestColor < $colors['red'] + $colors['green'] + $colors['blue']) {
                    $brightestColor = $colors['red'] + $colors['green'] + $colors['blue'];
                    $brightestColors = $colors;
                    // dump($brightestColors);
                }
            }
        }
        return str_pad(dechex($brightestColors['red']), 2, '0', STR_PAD_LEFT).str_pad(dechex($brightestColors['green']), 2, '0', STR_PAD_LEFT).str_pad(dechex($brightestColors['blue']), 2, '0', STR_PAD_LEFT);
    }
    /**
     * Get the darkest color of the image
     * @return string
     */
    public function getDarkestColor(): string {
        $image = imagecreatefromstring($this->file);
        $width = imagesx($image);
        $height = imagesy($image);
        $darkestColor = 255 + 255 + 255;
        $darkestColors = [
            'red' => 255,
            'green' => 255,
            'blue' => 255
        ];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $rgb);
                if($darkestColor > $colors['red'] + $colors['green'] + $colors['blue']) {
                    $darkestColor = $colors['red'] + $colors['green'] + $colors['blue'];
                    $darkestColors = $colors;
                    // dump($darkestColors);
                }
            }
        }
        return str_pad(dechex($darkestColors['red']), 2, '0', STR_PAD_LEFT).str_pad(dechex($darkestColors['green']), 2, '0', STR_PAD_LEFT).str_pad(dechex($darkestColors['blue']), 2, '0', STR_PAD_LEFT);
    }

    /**
     * 異なる色合いの3つの最頻値を取得する
     * @return string[]
     */
    public function getTreeTypicalColors(): array {
        $img  = imagecreatefromstring($this->file);
        $imgX = imagesx($img); //ヨコと
        $imgY = imagesy($img); //タテのpx数を取得して
        $rgbMap = [];
        for ($y = 0; $y < $imgY; $y++) { //左上から右下にかけてfor文で走査
            for ($x = 0; $x < $imgX; $x++) {
                $rgb = imagecolorat($img, $x, $y); //rgbコードを取得して
                $r = ($rgb >> 16) & 0xFF; //赤を10進数に
                $g = ($rgb >> 8) & 0xFF; //緑を10進数に
                $b = $rgb & 0xFF; //青を10進数に
                if(!isset($rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")])) {
                    $rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")] = 0;
                } else {
                    $rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")] += 1;
                }
            }
        }
        arsort($rgbMap);
        // $rgbMap = array_slice($rgbMap, 0, 5);
        $colors = array_map('trim', array_keys($rgbMap));
        while(($firstColor = array_shift($colors)) && ($this->isCloseColor($firstColor, '000000') || $this->isCloseColor($firstColor, 'ffffff'))) {
        }
        while($this->isCloseColor($firstColor, $secondColor = array_shift($colors)) || ($this->isCloseColor($secondColor, '000000') || $this->isCloseColor($secondColor, 'ffffff'))) {
        }
        while(($this->isCloseColor($secondColor, $thirdColor = array_shift($colors)) || $this->isCloseColor($firstColor, $thirdColor)) || ($this->isCloseColor($thirdColor, '000000') || $this->isCloseColor($thirdColor, 'ffffff'))) {
        }
        return [$firstColor, $secondColor, $thirdColor];
    }
    /**
     * 色の最頻値を取得する
     * @return string[]
     */
    public function getModeColor(): string
    {
        $img  = imagecreatefromstring($this->file);
        $imgX = imagesx($img); //ヨコと
        $imgY = imagesy($img); //タテのpx数を取得して
        $rgbMap = [];
        for ($y = 0; $y < $imgY; $y++) { //左上から右下にかけてfor文で走査
            for ($x = 0; $x < $imgX; $x++) {
                $rgb = imagecolorat($img, $x, $y); //rgbコードを取得して
                $r = ($rgb >> 16) & 0xFF; //赤を10進数に
                $g = ($rgb >> 8) & 0xFF; //緑を10進数に
                $b = $rgb & 0xFF; //青を10進数に
                if(!isset($rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")])) {
                    $rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")] = 0;
                } else {
                    $rgbMap[(str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT). " ")] += 1;
                }
            }
        }
        $maxes = array_keys($rgbMap, max($rgbMap)); // 値が最大の要素を抜き出す
        $key_max_rgb = $maxes[0]; // 最初に出現した最大値のキー名を返す
        return trim($key_max_rgb);
    }

    /**
     * Find out if the colors are close.
     * @param string|null $color1
     * @param string|null $color2
     * @return bool
     */
    private function isCloseColor(?string $color1, ?string $color2): bool {
        if(is_null($color1) || is_null($color2)) {
            return false;
        }
        $color1 = self::hex2rgb($color1);
        $color2 = self::hex2rgb($color2);
        $r = $color1[0] - $color2[0];
        $g = $color1[1] - $color2[1];
        $b = $color1[2] - $color2[2];
        $distance = sqrt($r * $r + $g * $g + $b * $b);
        return $distance < 122;
    }

    /**
     * Convert hex to rgb
     * @param string $hex
     * @return array
     */
    public static function hex2rgb(string $hex): array {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return [$r, $g, $b];
    }

    /**
     * Get brightness from rgb
     * @param int $r
     * @param int $g
     * @param int $b
     * @return float
     */
    public static function getBrightness(int $r, int $g, int $b): float {
        return round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
    }
}
