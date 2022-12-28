<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Site;
use Carbon\Carbon;
use App\Lib\LinkPreview\LinkPreviewInterface;
use App\Lib\LinkPreview\MockLinkPreview;

class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // テスト時にはモックオブジェクトに切り替えておく
        $this->app->bind(LinkPreviewInterface::class, MockLinkPreview::class);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function index_表示される()
    {
        $response = $this->get(route('sites.index'));
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function create_表示されること()
    {
        $response = $this->get(route('sites.index'));
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     * @test
     * @dataProvider storeDataProvider
     * @return void
     */
    public function store_登録に成功する場合と失敗する場合($url, $result, $sessionError)
    {
        
        
        $response = $this->from(route('sites.create'))->post(route('sites.store'),[
            'url' => $url,
        ]);
        if($result === 'success') {
            $response->assertSessionHas('message', 'モックのタイトル の登録okです');
            $response->assertSessionHas('status', 'success');
            $response->assertRedirect(route('sites.index'));
            $this->assertDatabaseHas('sites', [
                'url' => $url,
                'title' => 'モックのタイトル',
                'description' => 'モックのdescription',
                'mode_color' => "ffffff",
            ]);
        } 
        if($result === 'error') {
            $response->assertRedirect(route('sites.create'));
            $response->assertSessionHasErrors($sessionError);
            $this->assertDatabaseMissing('sites', [
                'url' => $url,
                'title' => 'モックのタイトル',
                'description' => 'モックのdescription',
                'mode_color' => "ffffff",
            ]);
        }
    }

    /**
     * データプロバイダ
     *
     * @return array
     */
    public function storeDataProvider()
    {
        return [
            '正常に登録される' => ['https://v3.ja.vuejs.org/', 'success', []],
            'URLが無いバリデーションエラー' => ['', 'error', ['url']],
            'URLが長すぎるバリデーションエラー' => ['https://v3.ja.vuejs.org/1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890', 'error', ['url']],
            'URL形式ではないバリデーションエラー' => ['1234567890', 'error', ['url']],
        ];
    }

}
