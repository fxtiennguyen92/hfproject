<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Config;

class CusServiceOfficerAuthenticate
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
		if (auth()->check()) {
			if (auth()->user()->role == Config::get('constants.ROLE_CSO')
				|| auth()->user()->role == Config::get('constants.ROLE_ADM'))
			return $next($request);
		} else {
			return redirect()->route('login_page');
		}
		
		throw new NotFoundHttpException();
	}
}
