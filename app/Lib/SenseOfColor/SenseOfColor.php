<?php
namespace App\Lib\SenseOfColor;

final class SenseOfColor
{
    public function __construct(private string $file){}

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
                if(!isset($rgbMap[dechex($r).dechex($g).dechex($b)])) {
                    $rgbMap[dechex($r).dechex($g).dechex($b)] = 0;
                } else {
                    $rgbMap[dechex($r).dechex($g).dechex($b)] += 1;
                }
            }
        }
        $maxes = array_keys($rgbMap, max($rgbMap)); // 値が最大の要素を抜き出す
        $key_max_rgb = $maxes[0]; // 最初に出現した最大値のキー名を返す
        return $key_max_rgb;
    }
}
