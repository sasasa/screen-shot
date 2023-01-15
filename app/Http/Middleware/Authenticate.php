<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // アクセス先が管理画面の場合は管理画面ログイン画面へリダイレクト
            if ($request->is('system_admin/*')) {
                return route('system_admin.login');
            } else if ($request->is('production/*')) {
                return route('production.login');
            }
        }
    }
}
