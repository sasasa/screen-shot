<?php

namespace App\Http\Controllers;

use App\Services\IpService;
use Illuminate\Http\Request;
use App\Usecases\FindOrCreateUserByCookie;

class TermsController extends Controller
{
    public function index(Request $request, FindOrCreateUserByCookie $findOrCreateUserUseCase)
    {
        $user = $findOrCreateUserUseCase($request->cookie('userid'), IpService::getIp($request), $request->header('User-Agent'));
        return view('terms', [
            'users_sites' => $user->sites->pluck('id')->toArray(),
        ]);
    }
}
