<?php

namespace App\Http\Middleware;

use Closure;

class CheckProfileStatus
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
        $user = auth()->user();
        if($user->payment_status != PAYMENT_STATUS_PAID ) {
            if(!$request->ajax()) {
                return redirect()->route('member.activate_account');
            } else {
                return response('For Continue This Process, Please Contact Admin To Activate Your Membership.', PAYMENT_REQUIRED);
            }
        }

        return $next($request);
    }
}
