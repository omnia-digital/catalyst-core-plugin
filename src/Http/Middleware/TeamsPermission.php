<?php

namespace OmniaDigital\CatalystCore\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamsPermission
{
    public function handle(Request $request, Closure $next)
    {
        if (! empty($user = auth()->user()) && ! empty($user->current_team_id)) {
            setPermissionsTeamId($user->current_team_id);
        }

        return $next($request);
    }
}
