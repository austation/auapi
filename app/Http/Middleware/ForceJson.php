<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJson {
	/**
    * Set the Accept header to force json response
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
	public function handle(Request $request, Closure $next) {
		$request->headers->set('Accept', 'application/json');

		return $next($request);
	}
}
