<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;
use App\Models\Tag;
use App\Models\Contact;

class ProductionSidebar extends Component
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
        $contacts = Contact::query()->with('site')->where('is_done', false)->latest()->limit(10)->get();

        return view('components.production.sidebar', [
            // お問合せ未完了のもの
            'contacts' => $contacts,
        ]);
    }
}
