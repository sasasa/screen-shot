<?php
namespace App\Usecases;

use App\Enums\SortOrder;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Database\Query\JoinClause;
use App\Models\User;
final class GetSitesWithTagsAndColors
{
    /**
     * @param string|null $color
     * @param string|null $tag
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function __invoke(SortOrder $order, ?string $search, ?string $color, ?string $tag, ?string $favorites, User $user): \Illuminate\Pagination\LengthAwarePaginator
    {
        if($color) {
            if($tag) {
                if($favorites) {
                    $query = $user->sites()->with(['production', 'tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })->join('site_tag', function (JoinClause $join) use($tag){
                        $join->on('site_tag.site_id', '=', 'sites.id');
                        $join->whereRaw('site_tag.tag_id = (SELECT tags.id FROM tags WHERE tags.name = ?)', [$tag]);
                    });
                    // ->orderBy('site_colors.order', 'DESC');
                } else {
                    $query = Tag::where('name', $tag)->first()->sites()->with(['production', 'tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    });
                    // ->orderBy('site_colors.order', 'DESC');
                }
            } else {
                if($favorites) {
                    $query = $user->sites()->with(['production', 'tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    });
                    // ->orderBy('site_colors.order', 'DESC');
                } else {
                    $query = Site::query()->with(['production', 'tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    });
                    // ->orderBy('site_colors.order', 'DESC');
                }
            }
        } elseif($tag) {
            if($favorites) {
                $query = $user->sites()->with(['production', 'tags', 'site_colors'])->withCount('users')->join('site_tag', function (JoinClause $join) use($tag){
                    $join->on('site_tag.site_id', '=', 'sites.id');
                    $join->whereRaw('site_tag.tag_id = (SELECT tags.id FROM tags WHERE tags.name = ?)', [$tag]);
                });
                // ->orderBy('sites.id', 'DESC');
            } else {
                $query = Tag::where('name', $tag)->first()->sites()->with(['production', 'tags', 'site_colors'])->withCount('users');
                // ->orderBy('sites.id', 'DESC');
            }
        } else {
            if($favorites) {
                $query = $user->sites()->with(['production', 'tags', 'site_colors'])->withCount('users');
                // ->orderBy('sites.id', 'DESC');
            } else {
                $query = Site::query()->with(['production', 'tags', 'site_colors'])->withCount('users');
                // ->orderBy('sites.id', 'DESC');
            }
        }

        if($search) {
            $spaceConvert = mb_convert_kana($search, 's'); //全角スペースを半角に
            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY); //空白で区切る
            foreach($keywords as $word) {
                $query->where(function($q) use($word) {
                    $q->orWhere('sites.title','like', '%'.$word.'%');
                    $q->orWhere('sites.description','like', '%'.$word.'%');
                    $q->orWhere('sites.body','like', '%'.$word.'%');
                });
            }
        }

        if($order == SortOrder::RANDOM) {
            $query->inRandomOrder();
        } else if($order == SortOrder::POPULAR) {
            $query->orderBy('users_count', 'DESC')->orderBy('sites.id', 'DESC');
        } else if($order == SortOrder::NEW) {
            $query->orderBy('sites.id', 'DESC');
        } else if($order == SortOrder::OLD) {
            $query->orderBy('sites.id', 'ASC');
        } else if($order == SortOrder::COLOR && $color) {
            // カラー指定時のみ設定可能なソート
            $query->orderBy('site_colors.order', 'DESC');
        } else {
            $query->orderBy('sites.id', 'DESC');
        }

        return $query->paginate(15)->withQueryString();
    }
}