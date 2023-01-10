<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Site;
use App\Models\User;
use App\Models\Tag;
use App\Models\Contact;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Auth;
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
        // 今月のお問合せ
        $inquiries = Inquiry::where('production_id', Auth::guard('production')->user()->id)->whereMonth('created_at', date('m'))->get();
        // 先月のお問合せ
        $inquiries_last_month = Inquiry::where('production_id', Auth::guard('production')->user()->id)->whereMonth('created_at', date('m', strtotime('-1 month')))->get();
        return view('components.production.sidebar', [
            'inquiries' => $inquiries,
            'inquiries_last_month' => $inquiries_last_month,
        ]);
    }
}
