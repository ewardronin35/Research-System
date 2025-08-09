<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCodeIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the session does not have the validated code, redirect to the entry page.
        if (!session()->has('validated_research_code')) {
            return redirect()->route('guest.research.enter_code');
        }

        return $next($request);
    }
}