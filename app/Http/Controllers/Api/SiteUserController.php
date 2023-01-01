<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\User;

class SiteUserController extends Controller
{
    public function likes(Request $request)
    {
        if($request->hasCookie('userid')) {
            $site = Site::find($request->siteid);
            $user = User::where('uuid', $request->cookie('userid'))->first();
            $site->users()->attach($user->id);
            return response()->json([
                'likes_count' => $site->users()->count(),
                'message' => 'success'
            ]);
        } else {
            return response()->json(['message' => 'error']);
        }
    }

    public function unlikes(Request $request)
    {
        if($request->hasCookie('userid')) {
            $site = Site::find($request->siteid);
            $user = User::where('uuid', $request->cookie('userid'))->first();
            $site->users()->detach($user->id);
            return response()->json([
                'likes_count' => $site->users()->count(),
                'message' => 'success'
            ]);
        } else {
            return response()->json(['message' => 'error']);
        }
    }
}
