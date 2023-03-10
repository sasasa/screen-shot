<?php

namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Lib\LinkPreview\GetLinkPreviewResponse;

final class SiteCreateWithTags
{
    public function __construct()
    {
    }

    public function __invoke(GetLinkPreviewResponse $response): Site
    {
        try {
            // トランザクション開始
            DB::beginTransaction();
            $site = Site::create($response->toArray());
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
                'url' => '新規登録に失敗しました。再度投稿してください。'
            ]);
        }
    }
}