<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }

        if ($request->expectsJson()) {
            return null;
        }

        // Determine which guard is being used
        $guards = array_keys(config('auth.guards'));
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                continue;
            }

            if ($guard === 'employee') {
                return route('employeeLogin');
            }

            if ($guard === 'manager') {
                return route('Manager_Login');
            }

            if ($guard === 'telecaller') {
                return route('frontend.login');
            }
        }

        return route('user.login');
    }
}
