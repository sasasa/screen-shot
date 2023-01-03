<?php
namespace App\Usecases;

use App\Models\Site;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;
use App\Models\User;
final class GetSitesWithTagsAndColors
{
    /**
     * @param string|null $color
     * @param string|null $tag
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __invoke(?string $color, ?string $tag, ?string $favorites, User $user): \Illuminate\Database\Eloquent\Collection
    {
        if($color) {
            if($tag) {
                if($favorites) {
                    $query = $user->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })->join('site_tag', function (JoinClause $join) use($tag){
                        $join->on('site_tag.site_id', '=', 'sites.id');
                        $join->where('site_tag.tag_id', '=', Tag::where('name', $tag)->select('id')->first()->id);
                    })
                    ->orderBy('site_colors.order', 'DESC');
                } else {
                    $query = Tag::where('name', $tag)->first()->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })
                    ->orderBy('site_colors.order', 'DESC');
                }
            } else {
                if($favorites) {
                    $query = $user->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })
                    ->orderBy('site_colors.order', 'DESC');
                } else {
                    $query = Site::query()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })
                    ->orderBy('site_colors.order', 'DESC');
                }
            }
        } elseif($tag) {
            if($favorites) {
                $query = $user->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_tag', function (JoinClause $join) use($tag){
                    $join->on('site_tag.site_id', '=', 'sites.id');
                    $join->where('site_tag.tag_id', '=', Tag::where('name', $tag)->select('id')->first()->id);
                })
                ->orderBy('sites.id', 'DESC');
            } else {
                $query = Tag::where('name', $tag)->first()->sites()->with(['tags', 'site_colors'])->withCount('users')->orderBy('sites.id', 'DESC');
            }
        } else {
            if($favorites) {
                $query = $user->sites()->with(['tags', 'site_colors'])->withCount('users')->orderBy('sites.id', 'DESC');
            } else {
                $query = Site::query()->with(['tags', 'site_colors'])->withCount('users')->orderBy('sites.id', 'DESC');
            }
        }

        return $query->get();
    }
}