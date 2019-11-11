<?php

namespace App\Http\Middleware;

use Closure;

class ForceSSL
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
        $app_url = env('APP_URL');

        if ( !$request->secure() && substr($app_url, 0, 8) === 'https://' ) {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
