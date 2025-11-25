<?php

namespace App\Http\Middleware;

use Closure;

class VerifyMpesaCallback
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
        // You can add logic to verify the callback request here if needed

        return $next($request);
    }
}
