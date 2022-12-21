<?php

namespace App\Lib\LinkPreview;

interface LinkPreviewInterface
{
    public function get(string $url): GetLinkPreviewResponse;
    public function store(): void;
    public function getModeColor(): string;
}