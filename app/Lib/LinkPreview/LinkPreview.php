<?php
namespace App\Lib\LinkPreview;

use RuntimeException;
use App\Lib\SenseOfColor\SenseOfColor;
use KubAT\PhpSimple\HtmlDomParser;

final class LinkPreviewRuntimeException extends RuntimeException{}
final class LinkPreview implements LinkPreviewInterface
{
    private GetLinkPreviewResponse $response;
    private SenseOfColor $senseOfColor;

    public function get(string $url): GetLinkPreviewResponse
    {
        $parsed_url = parse_url($url);
        $domain = $parsed_url['host'];
        if($image = @file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$url&screenshot=true")){
            //ここにコンテンツの取得が成功した場合の処理
            $image = json_decode($image, true);
            $image = $image["lighthouseResult"]["audits"]["final-screenshot"]["details"]["data"];
            $data = preg_replace('#^data:image/\w+;base64,#i' , '' , $image);
            $fileData = base64_decode($data);
        } else {
            throw new LinkPreviewRuntimeException($url);
        }
        $dom = HtmlDomParser::file_get_html($url);
        $title = trim($dom->find('title', 0)->plaintext);
        $description = trim($dom->find('meta[name=description]', 0)->content);
        
        $this->senseOfColor = new SenseOfColor($fileData);
        $modeColor = $this->getModeColor();

        $this->response = new GetLinkPreviewResponse(
          title: $title,
          description: $description,
          fileData: $fileData,
          domain: $domain,
          modeColor: $modeColor,
        );
        $this->store();

        return $this->response;
    }

    public function store(): void
    {
      $path = storage_path('app/public/images'). "/". $this->response?->domain. ".jpeg";
      if (!file_exists($tmp_file_dir = storage_path('app/public/images'))) {
          mkdir($tmp_file_dir, 0777, true);
      }
      file_put_contents($path, $this->response?->fileData);
    }

    public function getModeColor(): string
    {
      return $this->senseOfColor?->getModeColor();
    }
}