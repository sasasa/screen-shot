<?php
namespace App\Lib\LinkPreview;

final class GetLinkPreviewResponse
{
    public function __construct(
        readonly public string $title,
        readonly public string $description,
        readonly public string $fileData,
        readonly public string $domain,
        readonly public string $url,
        readonly public ?string $modeColor,
        readonly public ?string $secondColor,
        readonly public ?string $thirdColor,
        readonly public string $darkestColor,
        readonly public string $brightestColor,
    ){}

    public function toArray(): array {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'fileData' => $this->fileData,
            'domain' => $this->domain,
            'mode_color' => $this->modeColor,
            'second_color' => $this->secondColor,
            'third_color' => $this->thirdColor,
            'darkest_color' => $this->darkestColor,
            'brightest_color' => $this->brightestColor,
        ];
    }
}