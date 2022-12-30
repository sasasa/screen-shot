<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;
use App\Models\Site;
use App\Models\SiteColor;

class SiteSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const THRESHOLD = 18; // 何％以上色があれば保存するか
    const THRESHOLD_MONO = 48; // 何％以上色があれば保存するか
    const BASE_COLORS = [  // 基準となる色
        'pink' => [230, 107, 88],
        'red' => [235, 0, 0],
        'green' => [45, 160, 0],
        'darkgreen' => [10, 80, 10],
        'blue' => [0, 0, 100],
        'brown' => [106, 52, 39],
        'skyblue' => [0, 125, 200],
        'yellow' => [200, 230, 0],
        'orange' => [250, 100, 0],
        'purple' => [128, 0, 128],
        'black' => [0, 0, 0],
        'gray' => [128, 128, 128],
        'darkgray' => [30, 30, 30],
        'lightgray' => [190, 190, 190],
        'white' => [255, 255, 255],
    ];

    /**
     * Create a new event instance.
     * @param Site $site
     * @return void
     */
    public function __construct(Site $site)
    {
        $path = storage_path('app/public/images'). "/". $site->imgsrc;
        if(!file_exists($path)) {
            return;
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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
