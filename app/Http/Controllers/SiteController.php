<?php

namespace App\Http\Controllers;

use App\Enums\SortOrder;
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
use App\Models\User;
use App\Services\IpService;
use Illuminate\Support\Str;
use App\Usecases\ChooseColor;
use App\Usecases\GetSitesWithTagsAndColors;
use App\Usecases\FindOrCreateUserByCookie;
class SiteController extends Controller
{
    public function tags(Request $request, CreateTagCloud $usecase, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));

        return response()->view('site.tags', [
            'tags' => $usecase(),
            'background_color' => ChooseColor::choose($request->color),
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ])->cookie('userid', $user->uuid, 60*24*365*10, null, null, false, false);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GetSitesWithTagsAndColors $getSitesUsecase, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));

        return response()->view('site.index', [
            'sort_orders' => SortOrder::cases(),
            'background_color' => ChooseColor::choose($request->color),
            'colors' => ChooseColor::getBaseColors(),
            'sites' => $getSitesUsecase(SortOrder::from($request->order), $request->search, $request->color, $request->tag, $request->favorites, $user),
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ])->cookie('userid', $user->uuid, 60*24*365*10, null, null, false, false);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));

        return response()->view('site.create', [
            'background_color' => ChooseColor::choose($request->color),
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ])->cookie('userid', $user->uuid, 60*24*365*10, null, null, false, false);
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
            $site = $usecase($linkPreview->get($request->url));
        } catch (LinkPreviewRuntimeException $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            throw ValidationException::withMessages([
                'url' => '何らかの理由で読み込めませんでした。時間をおいて再度投稿してください。'
            ]);
        }
        return to_route('sites.index')->with([
            'message' => "【{$site->title}】の登録okです。",
            'status' => 'success',
        ]);
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
