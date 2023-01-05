<?php

namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Lib\LinkPreview\GetLinkPreviewResponse;

final class SiteUpdate
{
    public function __construct()
    {
    }

    public function __invoke(GetLinkPreviewResponse $response): Site
    {
        try {
            // トランザクション開始
            DB::beginTransaction();
            $site = Site::where('url', $response->url)->first();
            $site->fill($response->toArray());
            $site->save();
            DB::commit();
            return $site;
        } catch (Exception $e) {
            // ロールバック
            DB::rollBack();
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            throw ValidationException::withMessages([
                'url' => '登録に失敗しました。再度投稿してください'
            ]);
        }
    }
}