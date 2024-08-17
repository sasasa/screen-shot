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
                'url' => 'https://www.akagi.com/products/index.html',
            ],
            [
                'url' => 'https://www.gohawaii.jp/ja',
            ],
            [
                'url' => 'https://www.cocacola.jp/2022xmas/',
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
                'url' => 'https://infinity-lawfirm.com/',
            ],
            [
                'url' => 'https://www.am.mufg.jp/recruit/',
            ],
            [
                'url' => 'https://alleeomotesando.jp/',
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
                'url' => 'https://www.amazon.co.jp/',
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
                'url' => 'https://cheesenessburger.com/',
            ],
            [
                'url' => 'https://payme.tokyo/',
            ],
            [
                'url' => 'https://www.koitoba.com/hotel/',
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
            [
                'url' => 'https://housefoods.jp/products/special/hokkaido_stew/index.html',
            ],
            [
                'url' => 'https://www.kubara.jp/',
            ],
            [
                'url' => 'https://www.mcdonalds.co.jp/menu/',
            ],
            [
                'url' => 'https://uo-sei.info/',
            ],
            [
                'url' => 'https://nikuya-oishi.co.jp/',
            ],
            [
                'url' => 'https://www.dosuika.com/',
            ],
            [
                'url' => 'https://www.clorets.jp/index.html',
            ],
            [
                'url' => 'https://ca-base-next.cyberagent.co.jp/2022/',
            ],
            [
                'url' => 'https://uekishun.com/',
            ],
            [
                'url' => 'https://nagoya.parco.jp/page/gyoza/',
            ],
            [
                'url' => 'https://www.kyotobank.co.jp/',
            ],
            [
                'url' => 'http://www.jyukai.com/',
            ],
            [
                'url' => 'https://e-vidal.jp/',
            ],
            [
                'url' => 'https://www.pocky.jp/',
            ],
            [
                'url' => 'https://www.japanpost.jp/',
            ],
            [
                'url' => 'https://www.natori.co.jp/',
            ],
            [
                'url' => 'https://parm-ice.jp/',
            ],
            [
                'url' => 'https://www.chiba-u.ac.jp/',
            ],
            [
                'url' => 'https://slim.co.jp/',
            ],
            [
                'url' => 'https://www.mlit.go.jp/kankocho/',
            ],
            [
                'url' => 'https://www.consuldent.jp/recruitment/',
            ],
            [
                'url' => 'https://ouc.daishodai.ac.jp/daisho12/',
            ],
            [
                'url' => 'https://www.kinasse-yatsushiro.jp/myoken/',
            ],
            [
                'url' => 'https://www.anniversal.jp/',
            ],
            [
                'url' => 'https://www.prints21.co.jp/',
            ],
            [
                'url' => 'https://www.first-kitchen.co.jp/',
            ],
            [
                'url' => 'https://hp.brs.nihon-u.ac.jp/~fbs/',
            ],
            [
                'url' => 'https://shop.fruoats.jp/',
            ],
            [
                'url' => 'https://www.city.iyo.lg.jp/',
            ],
            [
                'url' => 'https://orf.sfc.keio.ac.jp/2018/',
            ],
            [
                'url' => 'https://www.smappa.net/',
            ],
            [
                'url' => 'https://school.jp.yamaha.com/music_lesson/',
            ],
            [
                'url' => 'https://www.fstage.co.jp/',
            ],
            [
                'url' => 'https://sonarcareer.com/',
            ],
            [
                'url' => 'https://tokyo-festival.jp/2021/',
            ],
            [
                'url' => 'https://artproduce-kua.com/',
            ],
            [
                'url' => 'https://cocolo-gift.jp/',
            ],
            [
                'url' => 'https://mij-international.com/',
            ],
            [
                'url' => 'https://www.ignis.jp/io/',
            ],
            [
                'url' => 'https://hc.kowa.co.jp/hokkairo/',
            ],
        ];
        foreach($urls as $url) {
            Site::create($url);
        }
    }
}
