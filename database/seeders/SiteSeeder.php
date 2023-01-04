<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = [
            [
                'url' => 'https://www.akagi.com/products/index.html?tab01=garigari',
            ],
            [
                'url' => 'https://www.gohawaii.jp/ja',
            ],
            [
                'url' => 'https://www.cocacola.jp/2022xmas/',
            ],
            [
                'url' => 'https://toyota.jp/passo/',
            ],
            [
                'url' => 'https://qiita.com/azu369yu/items/3d8e7df610fe35dc1ad3',
            ],
            [
                'url' => 'https://thedental.jp/',
            ],
            [
                'url' => 'https://satoyama-jujo.com/thehouse/',
            ],
            [
                'url' => 'https://pf.quant.page/',
            ],
            [
                'url' => 'https://spiderplus.co.jp/25th/',
            ],
            [
                'url' => 'https://www.lion.co.jp/ja/',
            ],
            [
                'url' => 'https://midori-no-mori.jp/',
            ],
            [
                'url' => 'https://www2.mejiro.ac.jp/univ/mejinavi2022/',
            ],
            [
                'url' => 'https://www.beams.co.jp/special/kids_outer/',
            ],
            [
                'url' => 'https://www.care-plus.jp/staff/',
            ],
            [
                'url' => 'https://www.recaldent-gum.com/',
            ],
            [
                'url' => 'https://www.mononcle.jp/',
            ],
            [
                'url' => 'https://www.cocacola.jp/',
            ],
            [
                'url' => 'https://globalwork.jp/dadsday2022/',
            ],
            [
                'url' => 'https://infinity-lawfirm.com/',
            ],
            [
                'url' => 'https://www.am.mufg.jp/recruit/',
            ],
            [
                'url' => 'https://alleeomotesando.jp/',
            ],
            [
                'url' => 'https://zizo.ne.jp/',
            ],
            [
                'url' => 'https://www.wacoal.jp/wacoalbrand/happylingerie/',
            ],
            [
                'url' => 'https://www.mbs.jp/sotsureco/',
            ],
            [
                'url' => 'https://axinc.jp/',
            ],
            [
                'url' => 'https://www.jaist.ac.jp/ricenter/jaist-net/',
            ],
            [
                'url' => 'https://www.pilot-frixion-kaiho.jp/',
            ],
            [
                'url' => 'https://nishiyama-ramen.com/jp/',
            ],
            [
                'url' => 'https://awrd.com/sozo-yasashii/',
            ],
            [
                'url' => 'https://www.itude.jp/',
            ],
            [
                'url' => 'https://www.starbucks.co.jp/egift_holiday2021/',
            ],
            [
                'url' => 'https://okuyorovillage.com/',
            ],
            [
                'url' => 'https://mori-reform.jp/',
            ],
            [
                'url' => 'https://kuzu-core.com/',
            ],
            [
                'url' => 'https://k-toyoseiko.co.jp/',
            ],
            [
                'url' => 'https://www.sumida-aquarium.com/index.html',
            ],
            [
                'url' => 'https://www.kitamura-chem.co.jp/',
            ],
            [
                'url' => 'https://www.ut-ec.co.jp/',
            ],
            [
                'url' => 'https://opencare-taxi.com/',
            ],
            [
                'url' => 'https://r-equal.com/recruit/',
            ],
            [
                'url' => 'https://jp.creativesurvey.com/',
            ],
            [
                'url' => 'https://whatever.co/nandemo-day/ja/',
            ],
            [
                'url' => 'https://edex.adobe.com/jp/college-creative-jam-2021',
            ],
            [
                'url' => 'https://www.bt.com/about/annual-reports/2020summary/',
            ],
            [
                'url' => 'https://www.mochikichi.co.jp/',
            ],
            [
                'url' => 'https://www.kinotrope.co.jp/',
            ],
            [
                'url' => 'https://www.find-job.net/',
            ],
            [
                'url' => 'https://www.jp.square-enix.com/',
            ],
            [
                'url' => 'https://www.meiji.co.jp/foods/curry/ginza/',
            ],
            [
                'url' => 'https://otokomae.jp/',
            ],
            [
                'url' => 'https://www.amazon.co.jp/ref=nav_logo',
            ],
            [
                'url' => 'https://www.anime-chiikawa.jp/',
            ],
            [
                'url' => 'https://chibimaru.tv/',
            ],
            [
                'url' => 'https://www.lotte.co.jp/products/brand/bikkuri_man/',
            ],
            [
                'url' => 'https://www.cao.go.jp/',
            ],
            [
                'url' => 'https://www.nhk.or.jp/',
            ],
            [
                'url' => 'https://www.osakacastle.net/',
            ],
            [
                'url' => 'http://www.horyuji.or.jp/',
            ],
            [
                'url' => 'https://cheesenessburger.com/',
            ],
            [
                'url' => 'https://payme.tokyo/',
            ],
            [
                'url' => 'http://www.koitoba.com/hotel/',
            ],
            [
                'url' => 'https://www.hyponex.co.jp/',
            ],
            [
                'url' => 'https://townwork.net/',
            ],
            [
                'url' => 'https://www.otsuka.co.jp/cmt/',
            ],
            [
                'url' => 'https://www.nipponpapergroup.com/sustainableproducts/',
            ],
            [
                'url' => 'https://www.meiji.co.jp/sweets/biscuit/rich-biscuit/',
            ],
            [
                'url' => 'https://www.meiji.co.jp/sweets/chocolate/kinotake/',
            ],
            [
                'url' => 'https://www.meiji.co.jp/sweets/chocolate/chocokoka/',
            ],
        ];
        foreach($urls as $url) {
            Site::create($url);
        }
    }
}
