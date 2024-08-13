<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomPaymentToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasPaymentToken = $request->input('payment_token');

        if ($hasPaymentToken === env('MERCHANT_INCOMING_TOKEN')) {
            return $next($request);
        } else {
            return response()->json('Unauthorized', 401);
        }
    }
}