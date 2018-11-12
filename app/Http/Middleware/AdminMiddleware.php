<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check()) {
            if (Auth::user()->role < 5) {
                return redirect('messages')->with('message-error', 'У вас нет доступа к этой части сайта!');
            }
            return $next($request);
        } else
            return redirect('login');
    }

}
