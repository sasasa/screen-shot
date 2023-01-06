<?php
namespace App\Lib\LinkPreview;

final class MockLinkPreview implements LinkPreviewInterface
{
    public function get(string $url): GetLinkPreviewResponse
    {
        $parsed_url = parse_url($url);
        $domain = $parsed_url['host'];
        return new GetLinkPreviewResponse(
            url: $url,
            domain: $domain,
            title: 'モックのタイトル',
            description: 'モックのdescription',
            body: 'モックのbody',
            fileData: "xxx",
            modeColor: "ffffff",
            secondColor: "ff0000",
            thirdColor: "0000ff",
            darkestColor: "000000",
            brightestColor: "ffffff",
            tags: collect(['モック', 'PHP', 'Laravel']),
        );
    }
}