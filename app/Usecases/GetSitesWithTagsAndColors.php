<?php
namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;

final class GetSitesWithTagsAndColors
{
    /**
     * @param string|null $color
     * @param string|null $tag
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(?string $color, ?string $tag): \Illuminate\Database\Eloquent\Collection
    {
        if($color) {
            if($tag) {
                $query = Tag::where('name', $tag)->first()->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                    $join->on('site_colors.site_id', '=', 'sites.id');
                    $join->where('site_colors.color', '=', $color);
                })
                ->orderBy('site_colors.order', 'DESC');
            } else {
                $query = Site::query()->with(['tags', 'site_colors'])->withCount('users')
                ->join('site_colors', function (JoinClause $join) use($color){
                    $join->on('site_colors.site_id', '=', 'sites.id');
                    $join->where('site_colors.color', '=', $color);
                })
                ->orderBy('site_colors.order', 'DESC');
            }
        } elseif($tag) {
            $query = Tag::where('name', $tag)->first()->sites()->with(['tags', 'site_colors'])->withCount('users')->orderBy('sites.id', 'ASC');
        } else {
            $query = Site::query()->with(['tags', 'site_colors'])->withCount('users')->orderBy('sites.id', 'ASC');
        }

        return $query->get();
    }
}