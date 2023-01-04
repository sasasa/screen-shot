<?php
namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

final class RelateColors
{
    public function __construct()
    {
    }


    public function __invoke(Site $site, array $colors, array $orders): void
    {
        DB::beginTransaction();
        try {
            //紐づいたsite_colorsを全部削除する
            $site->site_colors()->delete();
            foreach ($colors as $color) {
                $site->site_colors()->create([
                    'color' => $color,
                    'order' => $orders[$color],
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            DB::rollBack();
            throw $e;
        }
    }
}