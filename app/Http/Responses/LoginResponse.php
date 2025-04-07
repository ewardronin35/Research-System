<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Check the user's role and redirect accordingly
        if (Auth::user()->hasRole('head')) {
            return redirect()->intended(route('head.dashboard'));
        }

        if (Auth::user()->hasRole('user')) {
            return redirect()->intended(route('user.dashboard'));
        }

        // Default redirect if no role matches (shouldn't happen if using Spatie)
        return redirect()->intended(config('fortify.home'));
    }
}