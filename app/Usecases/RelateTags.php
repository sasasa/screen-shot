<?php
namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

final class RelateTags
{
    public function __construct()
    {
    }

    /**
     * siteとtagを紐付ける
     * @param Site $site
     * @param string $tags [tag1] [tag2] [tag3] のような形式で送られてくる
     * @return void
     */
    public function __invoke(Site $site, string $tags): void
    {
        DB::beginTransaction();
        try {
            if(!empty($tags)){
                $ids = collect(preg_split("/[\s　]+/u", $tags))->map(function ($val) {
                    $tagName = mb_substr($val, 1, -1);
                    if(!empty($tagName)) {
                        $tag = Tag::firstOrCreate(['name' => $tagName]);
                        return $tag->id;
                    }
                });
                if($ids->count() > 0) {
                    $site->tags()->sync($ids);
                }
            } else {
                // 何も送られてこないときは全てのタグを解除する
                $site->tags()->sync([]);
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            DB::rollBack();
            throw $e;
        }
    }
}