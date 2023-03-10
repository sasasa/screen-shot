<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;
use App\Models\Tag;
use App\Models\Contact;
use App\Models\Production;

class AdminSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $contacts = Contact::query()->with('site')->where('is_done', false)->latest()->limit(100)->get();
        $sites = Site::query()->with('tags')->withCount('users')->latest()->limit(10)->get();
        $tags = Tag::query()->whereHas('site_tag', function($q) {
            // サイトの数が1以上のタグのみを取得
            $q->where('site_tag.site_id', '>=', '1');
        })->latest()->limit(30)->get();
        // inquiries問い合わせ数が多い順に並んだProduction
        $productions = Production::query()->withCount('inquiries')->orderBy('inquiries_count', 'desc')->limit(10)->get();
        return view('components.admin.sidebar', [
            // 新着サイト
            'sites' => $sites,
            // 新着タグ
            'tags' => $tags,
            // お問合せ未完了のもの
            'contacts' => $contacts,
            // 制作会社
            'productions' => $productions,
        ]);
    }
}
