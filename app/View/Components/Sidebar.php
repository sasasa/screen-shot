<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;

class Sidebar extends Component
{
    public ?string $color;
    public ?string $tag;
    public ?User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->color = request()->color;
        $this->tag = request()->tag;
        $this->user = User::where('uuid', request()->cookie('userid'))->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $sites = Site::query()->with('tags')->withCount('users')->latest()->limit(3)->get();
        $top3 = Site::query()->withCount('users')->orderBy('users_count', 'desc')->latest()->limit(3)->get();
        return view('components.sidebar', [
            'sites' => $sites,
            'tags' => $sites->map(function($site) {
                return ($site->tags);
            })->collapse(),
            'top3' => $top3,
            'users_sites' => $this->user?->sites->pluck('id')->toArray() ?? [],
        ]);
    }
}
