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
class SiteController extends Controller
{
    public function index()
    {
        return view('admin.sites.index', [
            'sites' => Site::paginate(20),
        ]);
    }

    public function destroy(Request $request, Site $site)
    {
        $site->delete();
        return redirect()->route('system_admin.sites.index');
    }

    public function edit(Site $site)
    {
        return view('admin.sites.edit', [
            'site' => $site,
        ]);
    }

    public function update(UpdateSiteRequest $request, Site $site, LinkPreviewInterface $linkPreview, SiteUpdateWithTags $usecase)
    {
        // トランザクションを開始する
        try {
            DB::beginTransaction();
            StoreImage::store($request->img, LinkPreview::getPath($site->url));
            $site = $usecase($linkPreview->get($site->url));
            //紐づいたsite_colorsを全部削除する
            $site->site_colors()->delete();
            (new ChooseColor)($site);
            DB::commit();
            return redirect()->back()->with('success', "{$site->title} を更新しました");
        } catch (Exception $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            DB::rollBack();
            throw $e;
        }
    }
}
