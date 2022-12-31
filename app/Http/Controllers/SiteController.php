<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Site;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\LinkPreviewRuntimeException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;
use App\Usecases\SiteCreateWithTags;
use App\Usecases\CreateTagCloud;
use App\Models\Tag;
class SiteController extends Controller
{
    public function tags(CreateTagCloud $usecase)
    {
        return view('site.tags', [
            'tags' => $usecase(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->color) {
            if($request->tag) {
                $query = Tag::where('name', $request->tag)->first()->sites()->join('site_colors', function (JoinClause $join) use($request){
                    $join->on('site_colors.site_id', '=', 'sites.id');
                    $join->where('site_colors.color', '=', $request->color);
                })
                ->select('sites.*')
                ->orderBy('site_colors.order', 'DESC');
            } else {
                $query = Site::query()
                ->join('site_colors', function (JoinClause $join) use($request){
                    $join->on('site_colors.site_id', '=', 'sites.id');
                    $join->where('site_colors.color', '=', $request->color);
                })
                ->select('sites.*')
                ->orderBy('site_colors.order', 'DESC');
            }
        } elseif($request->tag) {
            $query = Tag::where('name', $request->tag)->first()->sites()->orderBy('sites.id', 'ASC');
        } else {
            $query = Site::query()->orderBy('sites.id', 'ASC');
        }

        return view('site.index', [
            'sites' => $query->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSiteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteRequest $request, LinkPreviewInterface $linkPreview, SiteCreateWithTags $usecase)
    {
        try {
            $res = $linkPreview->get($request->url);
        } catch (LinkPreviewRuntimeException $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            throw ValidationException::withMessages([
                'url' => 'URLが存在しない等の理由で読み込めませんでした。変更して再度投稿してください'
            ]);
        }
        $site = $usecase($res);
        return to_route('sites.index')->with([
            'message' => "【{$site->title}】の登録okです",
            'status' => 'success',
        ]);;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSiteRequest  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteRequest $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
