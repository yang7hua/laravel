<?php

namespace App\Http\Middleware;

use Closure;

class HomeMiddleware
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
		//if (!$request->session()->has('xainfo') and \Route::current()->getName() != 'admin.login')
		//	return redirect()->route('admin.login');
		//echo \Route::current()->getName();
		//todo
        return $next($request);
    }
}
