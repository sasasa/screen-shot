<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateColorsRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Requests\UpdateTagsRequest;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Usecases\RelateColors;
use App\Usecases\RelateTags;
use App\Usecases\UpdateSiteEverytingWithImageUpdate;
use App\Usecases\UpdateSiteWithImageUpdate;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function destroy(Request $request, Site $site)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $site->inquiries->each(function ($inquiry) {
            $inquiry->site_id = null;
            $inquiry->save();
        });
        $site->delete();
        return redirect()->route('production.create')->with([
            'status' => "success",
            'message' => "{$site->title} を削除しました。",
        ]);
    }


    public function edit(Site $site)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        return view('production.sites.edit', [
            'site' => $site,
            // サイトの色
            'mycolors' => $site->site_colors->map(fn($c) => $c->color),
            // サイトの色をkeyでorderをvalueにした配列
            'mycolorsOrders' => $site->site_colors->map(fn($c) => [$c->color => $c->order])->collapse(),
        ]);
    }

    public function update_tags(UpdateTagsRequest $request, Site $site, RelateTags $usecase)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $usecase($site, $request->tags);
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} のタグを更新しました。",
        ]);
    }

    public function update_colors(UpdateColorsRequest $request, Site $site, RelateColors $usecase)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $usecase($site, $request->colors, $request->orders);
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} のカラーを更新しました。",
        ]);
    }

    public function update(UpdateSiteRequest $request, Site $site, UpdateSiteWithImageUpdate $usecase)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $usecase($site, $request->file('img'));
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} を更新しました。",
        ]);
    }

    public function crawl(Site $site, UpdateSiteEverytingWithImageUpdate $usecase)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $usecase($site);
        return redirect()->back()->with([
            'status' => "success",
            'message' => "{$site->title} を再構築しました。",
        ]);
    }
}
