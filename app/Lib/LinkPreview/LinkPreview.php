<?php
namespace App\Lib\LinkPreview;

use RuntimeException;
use App\Lib\SenseOfColor\SenseOfColor;
use KubAT\PhpSimple\HtmlDomParser;
use App\Lib\ScreenShot\ScreenShot;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Lib\Mecab\GetTags;
use App\Lib\InterventionImage\StoreImage;
use Carbon\Carbon;
use App\Models\Production;

final class LinkPreviewRuntimeException extends RuntimeException{}
final class LinkPreview implements LinkPreviewInterface
{
    /**
     * スクリーンショットを取得して、色を解析する
     * @param string $url
     * @return GetLinkPreviewResponse
     */
    public function get(string $url): GetLinkPreviewResponse
    {
        // execファイルがあるときはループを回してファイルが無くなるまで待つ
        $execFile = '/tmp/ScreenShot';
        $i = 0;
        while(file_exists($execFile)) {
            sleep(5);
            $i++;
            if($i > 10) {
                // ファイルを読み取り時間を取得
                $time = Carbon::createFromTimeString(file_get_contents($execFile));
                if(now()->diffInMinutes($time) >= 3) {
                    // 3分以上経過していたら削除
                    unlink($execFile);
                    break;
                }
                // 10回以上ループ55秒経過したらエラーで一旦返す
                throw new LinkPreviewRuntimeException('ScreenShot exec file is exists');
            }
        }
        // スクリーンショットを取得するまえにexecファイルを書き出す
        file_put_contents($execFile, now()->format('Y-m-d H:i:s'));

        // httpsにそろえてクエリストリングを削除
        $parsed_url = parse_url($url);
        $domain = $parsed_url['host'];
        $path = $parsed_url['path'];
        $url = 'https://'. $domain. $path;
        $url_domain = 'https://'. $domain;
        // $fileData = ScreenShot::getScreenshot($url);
        $header = [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:75.0) Gecko/20100101 Firefox/75.0",
        ];
        //オプション設定
        $options = stream_context_create([
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false
            ],
            'http' => [
                'method' => "GET",
                'header' => implode("\r\n", $header),
            ]
        ]);
        // ob_start();
        // imagepng(imagecreatefromstring($fileData), null, 0);
        // $size = ob_get_length();
        // $data = ob_get_clean();
        // $ocrContents = (new TesseractOCR())->imageData($data, $size)->lang('eng')->run();
        // if($fileData && !preg_match('/SSL.*handshake.*failed/i', $ocrContents)) {
            // SSL handshake failedという画像でないとき
        if(false) {
            // ScreenShot::getScreenshotはバグが多いので一旦保留
        } else {
            $path = self::getPath($url);
            if (file_exists($path)) {
                $fileData = file_get_contents($path);
            } else {
                if($image = @file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&screenshot=true", false, $options)){
                    //ここにコンテンツの取得が成功した場合の処理
                    $image = json_decode($image, true);
                    $image = $image["lighthouseResult"]["audits"]["final-screenshot"]["details"]["data"];
                    $data = preg_replace('#^data:image/\w+;base64,#i' , '' , $image);
                    $fileData = base64_decode($data);
                } else {
                    // httpsでは失敗するのでhttpで試す
                    $parsed_url = parse_url($url);
                    $domain = $parsed_url['host'];
                    $path = $parsed_url['path'];
                    $url = 'http://'. $domain. $path;
                    $url_domain = 'http://'. $domain;
                    if($image = @file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&screenshot=true", false, $options)){
                        //ここにコンテンツの取得が成功した場合の処理
                        $image = json_decode($image, true);
                        $image = $image["lighthouseResult"]["audits"]["final-screenshot"]["details"]["data"];
                        $data = preg_replace('#^data:image/\w+;base64,#i' , '' , $image);
                        $fileData = base64_decode($data);
                    } else {
                        // execファイルを削除する
                        unlink($execFile);
                        throw new LinkPreviewRuntimeException('image cant get: '. $url);
                    }
                }
            }
        }
        if ($dom = @HtmlDomParser::file_get_html($url, false, $options)) {
            $title =  mb_ereg_replace('/　|\s|\)/', '', trim($dom->find('title', 0)?->plaintext));
            $description = mb_ereg_replace('/　|\s|\)/', '', trim($dom->find('meta[name=description]', 0)?->content));
            $body = mb_ereg_replace('/　|\s|\)/', '', trim($dom->find('body', 0)?->plaintext));
            $tags = (new GetTags($title. $description. $body))->getTags();

            $production_code = $dom->find('meta[name=production]', 0)?->content;
            if(empty($production_code)) {
                // ドメイン直下からproduction.jsonを取得する
                $production_code = @file_get_contents($url_domain. "/production.json", false, $options);
                if($production_code) {
                    $decode = json_decode($production_code, true);
                    if($decode && isset($decode['production'])) {
                        $production_code = $decode['production'];
                    }
                }
            }
            $production = Production::where('register_url', $production_code)->first();

            // $senseOfColor = new SenseOfColor($fileData);
            // $modeColors = $senseOfColor->getTreeTypicalColors();
            // [$brightestColor, $darkestColor] = $senseOfColor->getBestColor();
 
            $this->store($url, $fileData);

            exec('node '. base_path(). '/node/colors.mjs '. self::getPathJpg($url), $output, $return_var);
            $palette = collect(json_decode(file_get_contents(self::getPathJpg($url). '.json'), true));
            $paletteKeyByName = $palette->keyBy('name');

            // dd($modeColors);
            $response = new GetLinkPreviewResponse(
                production_id: $production?->id,
                title: $title,
                description: mb_strimwidth($description, 0, 255, '…'),
                body: $body,
                fileData: $fileData,
                domain: $domain,
                url: $url,
                vibrant: $paletteKeyByName['Vibrant']['value'],
                darkVibrant: $paletteKeyByName['DarkVibrant']['value'],
                lightVibrant: $paletteKeyByName['LightVibrant']['value'],
                muted: $paletteKeyByName['Muted']['value'],
                darkMuted: $paletteKeyByName['DarkMuted']['value'],
                lightMuted: $paletteKeyByName['LightMuted']['value'],
                // modeColor: $modeColors[0],
                // secondColor: $modeColors[1],
                // thirdColor: $modeColors[2],
                // brightestColor: $brightestColor,
                // darkestColor: $darkestColor,
                tags: $tags
            );
            // execファイルを削除する
            unlink($execFile);

            return $response;
        } else {
            // execファイルを削除する
            unlink($execFile);
            throw new LinkPreviewRuntimeException('dom cant get: '. $url);
        }
    }

    /**
     * 画像を保存する
     * @param string $url
     * @param string $fileData
     * @return void
     */
    private function store(string $url, string $fileData): void
    {
        $path = self::getPath($url);
        $jpg_path = self::getPathJpg($url);
        if (!file_exists($tmp_file_dir = storage_path('app/public/images'))) {
            mkdir($tmp_file_dir, 0777, true);
        }
        StoreImage::store($fileData, $path);
        StoreImage::store($fileData, $jpg_path);
    }

    public static function getPath(string $url): string
    {
        return storage_path('app/public/images'). "/". str_replace('=', '', str_replace('?', '', str_replace(':', '', str_replace('/', '_', $url)))). ".webp";
    }
    public static function getPathJpg(string $url): string
    {
        return storage_path('app/public/images'). "/". str_replace('=', '', str_replace('?', '', str_replace(':', '', str_replace('/', '_', $url)))). ".jpg";
    }

}