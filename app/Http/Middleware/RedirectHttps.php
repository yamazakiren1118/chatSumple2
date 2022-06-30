<?php

namespace App\Http\Middleware;

use Closure;

class RedirectHttps
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
        if(\App::environment('production') && $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https'){
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
