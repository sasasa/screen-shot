<?php

namespace App\Http\Controllers\Production;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function destroy(Request $request, Site $site)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $site->production_id) {
            return abort(404);
        }
        $site->inquiries->each(function ($inquiry) {
            $inquiry->site_id = null;
            $inquiry->save();
        });
        $site->delete();
        return redirect()->route('production.create')->with([
            'status' => "success",
            'message' => "{$site->title} を削除しました。",
        ]);
    }
}
