<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
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


        if (array_intersect($user->getRoleNames()->toArray(), $role) != NULL) {
            // return array_intersect($role, $user->getRoleNames()->toArray());
            return $next($request);
        }

        return back();
    }
}
