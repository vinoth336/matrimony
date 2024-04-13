<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyPhoneNumber
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->phone_number_verified_at) {
            return redirect()->route('phone_number.verify');
        }

        return $next($request);
    }
}
