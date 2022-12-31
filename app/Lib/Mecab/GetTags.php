<?php
namespace App\Lib\Mecab;

use Illuminate\Support\Facades\Log;

final class GetTags {
    public function __construct(readonly public string $text) {
    }

    public function getTags(): \Illuminate\Support\Collection {
        $tags = [];
        /**文字数を数える */
        $text_length = mb_strlen($this->text);
        exec('echo "'. $this->text .'" | mecab -b '. $text_length, $output);
        if(!empty($output) && is_array($output)) {
            $tags = collect($output)
                ->slice(0, -1)
                ->map(function($item) {
                    $lines = explode("\t", $item);
                    // dump($lines);
                    $surface = $lines[0];
                    if(isset($lines[1])) {
                        $features = explode(',', $lines[1]);
                    } else {
                        $features = [];
                    }
                    return [
                        'surface' => $surface,
                        'features' => $features
                    ];
                })
                ->filter(function($item) {
                    if(mb_strlen($item['surface']) < 2) {
                        // 一文字の単語は除外
                        return false;
                    }
                    return data_get($item, 'features.0') === '名詞' && data_get($item, 'features.1') === '普通名詞';
                })
                ->pluck('surface')
                ->toArray();
        }
        $tag_counts = array_count_values($tags);
        $tag_counts = array_filter($tag_counts, function($value){
            return ($value >= 3);
        });
        arsort($tag_counts);
        return collect($tag_counts)->slice(0, 10)->keys();
    }
}
