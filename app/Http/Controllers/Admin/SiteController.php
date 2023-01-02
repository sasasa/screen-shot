<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function index()
    {
        return view('admin.sites.index', [
            'sites' => Site::all(),
        ]);
    }

    public function destroy(Request $request, Site $site)
    {
        $site->delete();
        return redirect()->route('system_admin.sites.index');
    }
}
