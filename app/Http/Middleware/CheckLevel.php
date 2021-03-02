<?php

namespace App\Http\Middleware;

use Closure;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {

            return redirect('/')->with('error','Please login');
        }

        

        $actions = $request->route()->getAction();
        // $roles = isset($actions['roles']) ? $actions['roles'] : null;
        $authorized_levels = isset($actions['authorized_levels']) ? $actions['authorized_levels'] : null;

        $user_level_id = $request->user()->level_id;


        if (in_array($user_level_id, $authorized_levels) || (!$authorized_levels) ) {
            return $next($request);
        }

        // return $next($request);

        return redirect('/401')->with('permissiondenied','Higher clearance required');
    }
}
