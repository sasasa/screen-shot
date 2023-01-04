<?php
namespace App\Usecases;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\InterventionImage\StoreImage;
use App\Usecases\SiteUpdateWithTags;
use Illuminate\Support\Facades\DB;
use App\Usecases\ChooseColor;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Site;
use App\Lib\LinkPreview\LinkPreview;

final class UpdateSiteEverythingWithImageUpdate
{
    public function __construct(private LinkPreviewInterface $linkPreview, private SiteUpdateWithTags $siteUpdateWithTagsUsecase, private ChooseColor $chooseColorUsecase)
    {
    }

    /**
     * 画像を更新したら、それに伴ってサイトのタグや、色なども更新する
     * @param \App\Models\Site $site
     * @param \Illuminate\Http\UploadedFile $img
     */
    public function __invoke(Site $site, \Illuminate\Http\UploadedFile $img)
    {
        try {
            DB::beginTransaction();
            // 画像を保存する
            StoreImage::store($img, LinkPreview::getPath($site->url));
            // 新しい画像からデータを取得してサイトを更新する※タグも更新される
            $site = $this->siteUpdateWithTagsUsecase->__invoke($this->linkPreview->get($site->url));
            $site->site_colors()->delete();//紐づいたsite_colorsを全部削除する
            // 新しい画像からサイトの色を取得して保存する
            $this->chooseColorUsecase->__invoke($site);
            DB::commit();
        } catch (Exception $e) {
            Log::error(__METHOD__ . PHP_EOL . var_export($e->getMessage(), true));
            DB::rollBack();
            throw $e;
        }
    }
}