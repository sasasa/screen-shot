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
                'url' => 'https://www.gohawaii.jp/ja',
            ],
            [
                'url' => 'https://www.cocacola.jp/2022xmas/',
            ],
            [
                'url' => 'https://toyota.jp/passo/',
            ],
            [
                'url' => 'https://www.akagi.com/products/index.html?tab01=garigari',
            ],
        ];
        foreach($urls as $url) {
            Site::create($url);
        }
    }
}
