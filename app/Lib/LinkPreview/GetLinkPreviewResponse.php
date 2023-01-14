<?php
namespace App\Lib\LinkPreview;

final class GetLinkPreviewResponse
{
    public function __construct(
        readonly public ?string $production_id,
        readonly public string $url,
        readonly public string $domain,
        readonly public ?string $title,
        readonly public ?string $description,
        readonly public ?string $body,
        readonly public string $fileData,
        readonly public string $vibrant,
        readonly public string $darkVibrant,
        readonly public string $lightVibrant,
        readonly public string $muted,
        readonly public string $darkMuted,
        readonly public string $lightMuted,
        // readonly public ?string $modeColor,
        // readonly public ?string $secondColor,
        // readonly public ?string $thirdColor,
        // readonly public string $darkestColor,
        // readonly public string $brightestColor,
        readonly public \Illuminate\Support\Collection $tags,
    ){}

    public function toArray(): array {
        return [
            'production_id' => $this->production_id,
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'vibrant' => $this->vibrant,
            'dark_vibrant' => $this->darkVibrant,
            'light_vibrant' => $this->lightVibrant,
            'muted' => $this->muted,
            'dark_muted' => $this->darkMuted,
            'light_muted' => $this->lightMuted,
        ];
    }
}