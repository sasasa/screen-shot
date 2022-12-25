<?php
namespace App\Lib\LinkPreview;

final class GetLinkPreviewResponse
{
    public function __construct(
        readonly public string $title,
        readonly public string $description,
        readonly public string $fileData,
        readonly public string $domain,
        readonly public string $modeColor,
        readonly public string $secondColor,
        readonly public string $thirdColor,
    ){}
}