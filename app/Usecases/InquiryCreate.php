<?php
namespace App\Usecases;
use App\Models\Site;

final class InquiryCreate
{
    public function __invoke(int $siteId, int $type): Site
    {
        $site = Site::find($siteId);
        $site->inquiries()->create([
            'type' => $type,
            'production_id' => $site->production_id,
        ]);
        return $site;
    }
}