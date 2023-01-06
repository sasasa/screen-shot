<?php
namespace App\Lib\LinkPreview;

final class GetLinkPreviewResponse
{
    public function __construct(
        readonly public string $url,
        readonly public string $domain,
        readonly public string $title,
        readonly public string $description,
        readonly public string $body,
        readonly public string $fileData,
        readonly public ?string $modeColor,
        readonly public ?string $secondColor,
        readonly public ?string $thirdColor,
        readonly public string $darkestColor,
        readonly public string $brightestColor,
        readonly public \Illuminate\Support\Collection $tags,
    ){}

    public function toArray(): array {
        return [
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'mode_color' => $this->modeColor,
            'second_color' => $this->secondColor,
            'third_color' => $this->thirdColor,
            'darkest_color' => $this->darkestColor,
            'brightest_color' => $this->brightestColor,
        ];
    }
}