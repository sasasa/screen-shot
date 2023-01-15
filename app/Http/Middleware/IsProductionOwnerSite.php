<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsProductionOwnerSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $production = Auth::guard('production')->user();
        if ($production->id !== $request->site?->production_id) {
            Log::error(__METHOD__ . PHP_EOL ."production_id: {$production->id} !== {$request->site?->production_id}");
            return abort(403);
        }
        return $next($request);
    }
}
