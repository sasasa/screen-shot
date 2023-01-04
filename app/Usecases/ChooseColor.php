<?php
namespace App\Usecases;

use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;
use App\Models\Site;
use App\Models\SiteColor;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Usecases\SiteUpdateWithTags;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use Illuminate\Validation\ValidationException;
final class ChooseColor
{
    public const PINK = [230, 107, 88];
    public const RED = [235, 0, 0];
    public const GREEN = [45, 160, 0];
    public const DARKGREEN = [10, 80, 10];
    public const BLUE = [0, 0, 100];
    public const BROWN = [106, 52, 39];
    public const SKYBLUE = [0, 125, 200];
    public const YELLOW = [200, 230, 0];
    public const ORANGE = [250, 100, 0];
    public const PURPLE = [128, 0, 128];
    public const BLACK = [0, 0, 0];
    public const GRAY = [128, 128, 128];
    public const DARKGRAY = [30, 30, 30];
    public const LIGHTGRAY = [190, 190, 190];
    public const WHITE = [255, 255, 255];

    const THRESHOLD = 18; // 何％以上色があれば保存するか
    const THRESHOLD_MONO = 48; // 何％以上色があれば保存するか
    public const BASE_COLORS = [  // 基準となる色
        'pink' => self::PINK,
        'red' => self::RED,
        'green' => self::GREEN,
        'darkgreen' => self::DARKGREEN,
        'blue' => self::BLUE,
        'brown' => self::BROWN,
        'skyblue' => self::SKYBLUE,
        'yellow' => self::YELLOW,
        'orange' => self::ORANGE,
        'purple' => self::PURPLE,
        'black' => self::BLACK,
        'gray' => self::GRAY,
        'darkgray' => self::DARKGRAY,
        'lightgray' => self::LIGHTGRAY,
        '' => self::WHITE,
    ];

    /**
     * コントローラーに渡す色の配列を返す
     * @return array
     */
    public static function getBaseColors() : array
    {
        return collect(self::BASE_COLORS)->map(fn($val, $key) => [
            $key => self::rgb2hex($val),
        ])->collapse()->toArray();
    }

    /**
     * コントローラーに色のhexを返す
     * @param string|null $color
     * @return string
     */
    public static function choose(?string $color) : string
    {
        if($color === null) {
            return self::rgb2hex(self::WHITE);
        }
        return self::rgb2hex(self::BASE_COLORS[$color]);
    }

    /**
     * RGBからhexを返す
     * @param array $rgb
     * @return string
     */
    public static function rgb2hex(array $rgb) : string
    {
        return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
    }

    /**
     * 近い色を選択して保存する
     * @param Site $site
     * @return void
     */
    public function __invoke(Site $site)
    {
        $path = storage_path('app/public/images'). "/". $site->imgsrc;
        if(!file_exists($path)) {
            try {
                $linkPreview = app()->make(LinkPreviewInterface::class);
                $res = $linkPreview->get($site->url);
            } catch (LinkPreviewRuntimeException $e) {
                Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
                return;
            }
            $usecase = app()->make(SiteUpdateWithTags::class);
            $site = $usecase($res);
        }
        $palette = Palette::fromFilename($path);
        $all_color_count = 0;
        $extracted_color_counts = [
            'pink' => 0,
            'brown' => 0,
            'skyblue' => 0,
            'red' => 0,
            'green' => 0,
            'darkgreen' => 0,
            'blue' => 0,
            'yellow' => 0,
            'purple' => 0,
            'black' => 0,
            'orange' => 0,
        ];

        foreach($palette as $color => $count) {
            $extracted_rgb = array_values(
                Color::fromIntToRgb($color)
            );
            $min_distance = 765; // 最大距離からスタート
            $color_key = '';

            foreach(self::BASE_COLORS as $key => $rgb) {
                $color_distance = $this->getColorDistance($extracted_rgb, $rgb);
                if($color_distance < $min_distance) {
                    $min_distance = $color_distance;
                    $color_key = $key;
                }
            }
            if(in_array($color_key, ['orange', 'pink', 'brown', 'skyblue', 'black', 'red', 'blue', 'yellow', 'green', 'purple', 'darkgreen'])) {
                $extracted_color_counts[$color_key] += $count;
                $all_color_count += $count;
            }
        }

        foreach($extracted_color_counts as $color_key => $count) {
            $percentage = $count / $all_color_count * 100;
            if($count > 0 && in_array($color_key, ['orange', 'pink', 'skyblue', 'red', 'blue', 'yellow', 'green', 'purple','darkgreen'])) {
                if($percentage > self::THRESHOLD) { // しきい値より大きければ保存する
                    $site_color = new SiteColor();
                    $site_color->site_id = $site->id;
                    $site_color->order = $percentage;
                    $site_color->color = $color_key;
                    $site_color->save();
                }
            } elseif($count > 0 && in_array($color_key, ['brown', 'black'])) {
                if($percentage > self::THRESHOLD_MONO) {
                    $site_color = new SiteColor();
                    $site_color->site_id = $site->id;
                    $site_color->order = $percentage;
                    $site_color->color = $color_key;
                    $site_color->save();
                }
            }
        }
    }

    /**
     * ２つの色がどれだけ離れているかを取得
     * @param array $color_1
     * @param array $color_2
     * @return float
     */
    private function getColorDistance($color_1, $color_2) {
        return sqrt(
            pow($color_1[0] - $color_2[0], 2) +
            pow($color_1[1] - $color_2[1], 2) +
            pow($color_1[2] - $color_2[2], 2));
    }
}