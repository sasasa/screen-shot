<?php
namespace App\Lib\Mecab;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

final class GetTags {
    private const API_URL = "https://jlp.yahooapis.jp/JIMService/V2/conversion";
    private const NG_WORDS = [
        'こと',
        'ため',
        'もの',
        'よし',
    ];

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
                    if(in_array($item['surface'], self::NG_WORDS)) {
                        // NGワードは除外
                        return false;
                    }
                    if(mb_strlen($item['surface']) < 2) {
                        // 一文字の単語は除外
                        return false;
                    }
                    return (data_get($item, 'features.0') === '名詞' && data_get($item, 'features.1') === '普通名詞') ||
                            (data_get($item, 'features.0') === '名詞' && data_get($item, 'features.1') === '地名') ||
                            (data_get($item, 'features.0') === '名詞' && data_get($item, 'features.1') === '人名') ||
                            (data_get($item, 'features.0') === '名詞' && data_get($item, 'features.1') === '組織名') ||
                            (data_get($item, 'features.0') === '名詞' && preg_match('/^.*名詞$/u', data_get($item, 'features.1')));
                    // return data_get($item, 'features.0') === '名詞';
                })
                ->pluck('surface')
                ->toArray();
        }
        $tag_counts = array_count_values($tags);
        $tag_counts = array_filter($tag_counts, function($value){
            return ($value >= 3);
        });
        arsort($tag_counts);
        $tag_counts_kanji = collect($tag_counts)->slice(0, 10)->keys()->map(function($item) {
            if (preg_match('/^[ぁ-ゞ]+$/u', $item)) {
                sleep(5);
                // APIへのPOSTリクエストを送る
                $res = Http::withHeaders([
                    "Content-Type" => "application/json",
                    "User-Agent" => "Yahoo AppID: ". env('YAHOO_APP_ID'),
                ])->post(self::API_URL, [
                    "id" => "1234-1",
                    "jsonrpc"=> "2.0",
                    "method"=> "jlp.jimservice.conversion",
                    "params"=> [
                        "q"=> $item,
                        "format"=> "roman",
                        "mode"=> "kanakanji",
                        // "option"=> ["hiragana", "katakana", "alphanumeric", "half_katakana", "half_alphanumeric"],
                        "dictionary"=> ["base", "name", "place", "zip", "symbol"],
                        "results"=> 999
                    ]
                ]);
                if($res->successful()) {
                    // 漢字を取得
                    Log::info(__METHOD__ . PHP_EOL . var_export($res->body(), true));
                    return $res['result']['segment'][0]['candidate'][0];
                } else {
                    Log::error(__METHOD__ . PHP_EOL . var_export($res->body(), true));
                    return $item;
                }
            } else {
                return $item;
            }
        });
        return $tag_counts_kanji;
    }
}
