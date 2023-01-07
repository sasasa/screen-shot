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
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function __invoke(?string $search, ?string $color, ?string $tag, ?string $favorites, User $user): \Illuminate\Pagination\LengthAwarePaginator
    {
        if($color) {
            if($tag) {
                if($favorites) {
                    $query = $user->sites()->with(['tags', 'site_colors'])->withCount('users')->join('site_colors', function (JoinClause $join) use($color){
                        $join->on('site_colors.site_id', '=', 'sites.id');
                        $join->where('site_colors.color', '=', $color);
                    })->join('site_tag', function (JoinClause $join) use($tag){
                        $join->on('site_tag.site_id', '=', 'sites.id');
                        $join->whereRaw('site_tag.tag_id = (SELECT tags.id FROM tags WHERE tags.name = ?)', [$tag]);
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
                    $join->whereRaw('site_tag.tag_id = (SELECT tags.id FROM tags WHERE tags.name = ?)', [$tag]);
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

        if($search) {
            $spaceConvert = mb_convert_kana($search, 's'); //全角スペースを半角に
            $keywords = preg_split('/[\s]+/', $spaceConvert, -1, PREG_SPLIT_NO_EMPTY); //空白で区切る
            foreach($keywords as $word) {
                $query->orWhere('sites.title','like', '%'.$word.'%');
                $query->orWhere('sites.description','like', '%'.$word.'%');
                $query->orWhere('sites.body','like', '%'.$word.'%');
            }
        }

        return $query->paginate(15)->withQueryString();
    }
}