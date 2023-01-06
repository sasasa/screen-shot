<?php

namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Lib\LinkPreview\GetLinkPreviewResponse;
use App\Usecases\SiteUpdate;

final class SiteUpdateWithTags
{
    public function __construct(private SiteUpdate $siteUpdateUsecase)
    {
    }

    public function __invoke(GetLinkPreviewResponse $response): Site
    {
        try {
            // トランザクション開始
            DB::beginTransaction();
            $site = $this->siteUpdateUsecase->__invoke($response);
            $tagIds = $response->tags->map(function ($tag) {
                return Tag::firstOrCreate(['name' => $tag])->id;
            });
            $site->tags()->sync($tagIds);
            DB::commit();
            return $site;
        } catch (Exception $e) {
            // ロールバック
            DB::rollBack();
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            throw ValidationException::withMessages([
                'url' => '更新に失敗しました。再度投稿してください。'
            ]);
        }
    }
}