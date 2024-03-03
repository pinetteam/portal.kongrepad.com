<?php

namespace App\Http\Middleware;

use App\Models\System\Country\Country;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePhoneVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and phone is verified
        if ($request->user() && Auth::user()->phone_verified_at === null) {
            $phone_countries = Country::get();
            return redirect()->route('portal.sms-verification.index', compact(['phone_countries']));
        }

        return $next($request);
    }
}
