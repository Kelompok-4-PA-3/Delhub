<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role)
    // : Response
    {
        // return $role;
        $user  = Auth::User();
        // dd($role);
        // dd($user->getRoleNames()->toArray());
        // $roles = ['admin','dosen','staf'];
        // dd($roles);


        // dd(array_intersect($roles, $role));
        // check if a user has a role
        if ($user->hasRole($role)) {
            return $next($request);
        }
        // if (array_intersect($user->getRoleNames()->toArray(), $role) != NULL) {
        //     // return array_intersect($role, $user->getRoleNames()->toArray());
        //     return $next($request);
        // }

        return back();
    }
}
