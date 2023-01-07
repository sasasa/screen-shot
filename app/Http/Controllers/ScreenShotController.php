<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use Dusterio\LinkPreview\Client;
use KubAT\PhpSimple\HtmlDomParser;
use LithiumDev\TagCloud\TagCloud;
use App\Models\Tag;
use App\Usecases\CreateTagCloud;
use Carbon\Carbon;
use App\Lib\LinkPreview\LinkPreview;

class ScreenShotController extends Controller
{


    /**
     * Fibonacci sequence
     */
    private function fibonacciSequence(int $n): array {
        $sequence = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $sequence[$i] = $sequence[$i - 1] + $sequence[$i - 2];
        }
        return $sequence;
    }


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, string $url, LinkPreviewInterface $linkPreview, CreateTagCloud $usecase)
    {
        // [{"name":"Vibrant","value":"#a31ff5"},{"name":"DarkVibrant","value":"#50057e"},{"name":"LightVibrant","value":"#eedb82"},{"name":"Muted","value":"#ac84bc"},{"name":"DarkMuted","value":"#5c0692"},{"name":"LightMuted","value":"#d4a4b2"}]
        exec('npm run palette '. LinkPreview::getPathJpg('https://awrd.com/sozo-yasashii/'));
        // dd($output);

        $time = Carbon::createFromTimeString('2023-01-06 22:00:00');
        dd(now()->diffInMinutes($time));
        
        dd($usecase()->first());
        
        // $cloud = new TagCloud();
        // Tag::query()->withCount('sites')->orderBy('sites_count', 'desc')->get()->each(function($tag) use($cloud){
        //     // dump($tag->name, $tag->sites_count);
        //     $count = $tag->sites_count;
        //     if($count > 10) {
        //         $count = 10;
        //     }
        //     $cloud->addTag([
        //         'tag' => $tag->name,
        //         'path' => "sites/{$tag->name}",
        //         'color' => $count,
        //         'size' => $count,
        //     ]);
        // });

        // // $cloud->addTag(['tag' => 'php',  'path' => 'sites/1', 'color' => 1, 'size' => 1]);
        // // $cloud->addTag(['tag' => 'ajax', 'path' => 'sites/2', 'color' => 2, 'size' => 2]);
        // // $cloud->addTag(['tag' => 'css',  'path' => 'sites/3', 'color' => 3, 'size' => 3]);
        // $cloud->setOrder('color','DESC');
        // $cloud->setHtmlizeTagFunction(function($tag, $size) {
        //     $link = "<a href='/{$tag['path']}'>". $tag['tag']. '</a>';
        //     return "<span class='tag size-{$tag['size']} colour-{$tag['color']}'>{$link}</span> ";
        // });
        // echo $cloud->render();
        exit;
        try {
            $dom = HtmlDomParser::file_get_html('https://blog.capilano-fw.com/?p=3958');
            $body = trim($dom->find('body', 0)->plaintext);
            $tags = [];
            /**
             * Receive data from mecab command
             */
            exec('echo "'. $body .'" | mecab', $output);
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
            dd(collect($tag_counts)->slice(0, 10)->keys());

            // phpinfo();


            $options = stream_context_create(['ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false
            ]]);
            dd(file_get_contents('https://www.akagi.com/products/index.html?tab01=garigari', false, $options));
            dd($this->fibonacciSequence(113));

            // $previewClient = new Client("https://www.google.com/maps/place/".urlencode("〒814-0001+福岡県福岡市早良区百道浜４丁目５−３"));
            // $previewClient = new Client($url);
            // $response = $previewClient->getPreview('general')->toArray();
            // dd(mb_convert_encoding($response["title"], "UTF-8", "auto"));

            // $response = $linkPreview->get("https://www.google.com/maps/place/".urlencode("〒814-0001+福岡県福岡市早良区百道浜４丁目５−３"));
            $response = $linkPreview->get($url);
            dd($response);
            $linkPreview->store();
            $modeColor = $linkPreview->getModeColor();
    
            return response($response->fileData)->withHeaders([
                'Content-Type' => 'image/webp',
            ]);
        } catch (LinkPreviewRuntimeException $e) {
            // dd($e);
            abort(404);
        }

    }
}


