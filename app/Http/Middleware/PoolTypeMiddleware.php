<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PoolTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->route()->getName() === 'survivor.show')
        {
            if($request->route('pool') && $request->route('pool')->type === 'survivor') {
                return $next($request);
            } elseif($request->route('pool') && $request->route('pool')->type === 'pickem') {
                return redirect()->route('pickem.show', ['pool' => $request->route('pool')]);
            } else {
                abort(404);
            }

        } elseif($request->route()->getName() === 'pickem.show') {

            if($request->route('pool') && $request->route('pool')->type === 'pickem') {
                return $next($request);
            } elseif($request->route('pool') && $request->route('pool')->type === 'survivor') {
                return redirect()->route('survivor.show', ['pool' => $request->route('pool')]);
            } else {
                abort(404);
            }

        }

        return $next($request);
        /*
        if($request->route('pool') && $request->route('pool')->type === 'survivor') {
            dd($request->route()->getName());
        }
        dd($request->route('pool')->type);
        return $next($request);
        */
    }
}
