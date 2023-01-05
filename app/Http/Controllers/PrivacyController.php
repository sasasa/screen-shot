<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usecases\FindOrCreateUserByCookie;

class PrivacyController extends Controller
{
    public function index(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'));
        return view('privacy', [
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ]);
    }
}
