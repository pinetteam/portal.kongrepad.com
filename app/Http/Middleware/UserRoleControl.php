<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserRoleControl
{
    public function handle(Request $request, Closure $next)
    {
        $route = Route::currentRouteName();
        $user_routes = Auth::check() ? Auth::user()->role->access_scopes : [];
        if(isset($user_routes)) {
            if(in_array($route, $user_routes)) {
                return $next($request);
            } else {
                return back()->with("error","Bunu yapmaya izniniz yok!");
            }
        } else {
            return redirect()->route('auth.login.index');
        }
    }
}
