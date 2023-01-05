<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\LinkPreview\LinkPreview;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Tag;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\InterventionImage\StoreImage;
use App\Http\Requests\UpdateSiteRequest;
use App\Usecases\SiteUpdateWithTags;
use Illuminate\Support\Facades\DB;
use App\Usecases\ChooseColor;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Rules\TagRule;
use App\Usecases\RelateTags;
use App\Http\Requests\UpdateColorsRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Usecases\RelateColors;
use App\Usecases\UpdateSiteEverythingWithImageUpdate;
use App\UseCases\SiteUpdate;
class SiteController extends Controller
{
    public function index()
    {
        return view('admin.sites.index', [
            'sites' => Site::orderBy('id', 'DESC')->paginate(20),
        ]);
    }

    public function destroy(Request $request, Site $site)
    {
        $site->delete();
        return redirect()->route('system_admin.sites.index')->with([
            'status' => "success",
            'message' => "{$site->title} を削除しました",
        ]);
    }

    public function edit(Site $site)
    {
        return view('admin.sites.edit', [
            'site' => $site,
            // サイトの色
            'mycolors' => $site->site_colors->map(fn($c) => $c->color),
            // サイトの色をkeyでorderをvalueにした配列
            'mycolorsOrders' => $site->site_colors->map(fn($c) => [$c->color => $c->order])->collapse(),
        ]);
    }

    public function update_tags(UpdateTagsRequest $request, Site $site, RelateTags $usecase)
    {
        $usecase($site, $request->tags);
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} のタグを更新しました",
        ]);
    }

    public function update_colors(UpdateColorsRequest $request, Site $site, RelateColors $usecase)
    {
        $usecase($site, $request->colors, $request->orders);
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} のカラーを更新しました",
        ]);
    }

    public function update(UpdateSiteRequest $request, Site $site, UpdateSiteEverythingWithImageUpdate $usecase)
    {
        $usecase($site, $request->file('img'));
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} を更新しました",
        ]);
    }
}
