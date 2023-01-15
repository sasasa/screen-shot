<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoginRequireMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $guard = 'admin')
    {
        if(!Auth::guard($guard)->check() && $guard == 'admin'){
            return redirect()->route('system_admin.login');
        } else if(!Auth::guard($guard)->check() && $guard == 'production'){
            return redirect()->route('production.login');
        }
        return $next($request);
    }
}
