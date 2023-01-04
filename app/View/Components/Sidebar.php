<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;
use App\Models\Tag;

class Sidebar extends Component
{
    public ?string $color;
    public ?string $tag;
    public array $usersSites;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $usersSites)
    {
        $this->color = request()->color;
        $this->tag = request()->tag;
        $this->usersSites = $usersSites;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $sites = Site::query()->with('tags')->withCount('users')->latest()->limit(3)->get();
        $top3 = Site::query()->with('tags')->withCount('users')->orderBy('users_count', 'desc')->latest()->limit(3)->get();
        return view('components.sidebar', [
            'sites' => $sites,
            'popular_tags' => Tag::query()->withCount('sites')->orderBy('sites_count', 'desc')->limit(10)->get(),
            'tags' => $sites->map(function($site) {
                return ($site->tags);
            })->collapse(),
            'top3' => $top3,
            'users_sites' => $this->usersSites,
        ]);
    }
}
