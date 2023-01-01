<?php
namespace App\Lib\LinkPreview;

use RuntimeException;
use App\Lib\SenseOfColor\SenseOfColor;
use KubAT\PhpSimple\HtmlDomParser;
use App\Lib\ScreenShot\ScreenShot;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Lib\Mecab\GetTags;

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
        $parsed_url = parse_url($url);
        $domain = $parsed_url['host'];
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
            $path = $this->getPath($url);
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
                    throw new LinkPreviewRuntimeException('image cant get: '. $url);
                }
            }
        }
        if ($dom = @HtmlDomParser::file_get_html($url, false, $options)) {
            $title = trim($dom->find('title', 0)->plaintext);
            $description = trim($dom->find('meta[name=description]', 0)?->content);
            $tags = (new GetTags(trim($dom->find('body', 0)->plaintext)))->getTags();
            $senseOfColor = new SenseOfColor($fileData);
            $modeColors = $senseOfColor->getTreeTypicalColors();
            // dd($modeColors);
            $response = new GetLinkPreviewResponse(
                title: $title,
                description: mb_strimwidth($description, 0, 255, '…'),
                fileData: $fileData,
                domain: $domain,
                url: $url,
                modeColor: $modeColors[0],
                secondColor: $modeColors[1],
                thirdColor: $modeColors[2],
                darkestColor: $senseOfColor->getDarkestColor(),
                brightestColor: $senseOfColor->getBrightestColor(),
                tags: $tags
            );
            $this->store($response);
            return $response;
        } else {
            throw new LinkPreviewRuntimeException('dom cant get: '. $url);
        }
    }

    /**
     * @param GetLinkPreviewResponse $response
     */
    private function store(GetLinkPreviewResponse $response): void
    {
        $path = $this->getPath($response?->url);
        if (!file_exists($tmp_file_dir = storage_path('app/public/images'))) {
            mkdir($tmp_file_dir, 0777, true);
        }
        file_put_contents($path, $response?->fileData);
    }

    private function getPath(string $url): string
    {
        return storage_path('app/public/images'). "/". str_replace('=', '', str_replace('?', '', str_replace(':', '', str_replace('/', '_', $url)))). ".jpeg";
    }

}