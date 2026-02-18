<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PreventForbiddenPayment
{
    public function handle(Request $request, Closure $next): Response
    {
         $pool = $request->route('pool');
         
         if($pool->contenders->doesntContain("user_id", Auth::user()->id)) {
            return $next($request);
         }
         return redirect()->route('pool.show', ['pool' => $pool->id]);
    }
}
