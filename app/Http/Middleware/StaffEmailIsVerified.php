<?php

namespace App\Http\Middleware;

use App\Staff;
use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Support\Facades\Redirect;

class StaffEmailIsVerified extends EnsureEmailIsVerified {

    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if ( ! $request->user('employee') ||
            ($request->user('employee') instanceof Staff && //MustVerifyEmail &&
                ! $request->user('employee')->hasVerifiedEmail()))
        {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('tenant.staff.verification.notice');
        }

        return $next($request);
    }
}
