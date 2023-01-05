<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;
use App\Models\Tag;

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
        $sites = Site::query()->with('tags')->withCount('users')->latest()->limit(10)->get();
        $tags = Tag::query()->whereHas('site_tag', function($q) {
            // サイトの数が1以上のタグのみを取得
            $q->where('site_tag.site_id', '>=', '1');
        })->latest()->limit(30)->get();
        return view('components.admin.sidebar', [
            'sites' => $sites,
            'tags' => $tags,
        ]);
    }
}
