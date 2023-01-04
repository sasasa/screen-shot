<?php
namespace App\Lib\InterventionImage;
use Intervention\Image\Facades\Image as InterventionImage;

final class StoreImage
{
    /**
     * 画像を保存する
     * @param string $fileData
     * @param string $path
     * @return void
     */
    public static function store(?string $fileData, string $path): void
    {
        $image = InterventionImage::make($fileData);
        $image->orientate();//回転補正
        $image->resize(
            500,
            null,
            function ($constraint) {
                // 縦横比を保持したままにする
                $constraint->aspectRatio();
                // 小さい画像は大きくしない
                $constraint->upsize();
            }
        );
        $image->save($path);
    }
}