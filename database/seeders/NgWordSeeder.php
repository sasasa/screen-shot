<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NgWord;

class NgWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ng_words = [
            [
                'word' => 'こと',
            ],
            [
                'word' => 'ため',
            ],
            [
                'word' => 'もの',
            ],
            [
                'word' => 'よし',
            ],
            [
                'word' => 'コチラ',
            ],
            [
                'word' => 'ちんこ',
            ],
            [
                'word' => 'ちんぽ',
            ],
            [
                'word' => 'アナル',
            ],
            [
                'word' => 'まんこ',
            ],
            [
                'word' => 'おめこ',
            ],
            [
                'word' => 'ネトウヨ',
            ],
            [
                'word' => '朝鮮人',
            ],
            [
                'word' => 'えたひにん',
            ],
        ];
        foreach($ng_words as $ng_word) {
            NgWord::create($ng_word);
        }
    }
}
