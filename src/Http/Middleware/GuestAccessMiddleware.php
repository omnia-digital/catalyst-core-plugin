<?php

namespace OmniaDigital\CatalystCore\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;

class GuestAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ((new GeneralSettings)->allow_guest_access) {
            return $next($request);
        }

        if (auth()->check()) {
            return $next($request);
        }

//        return redirect()->route('login');
    }
}
