<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    

    public function handle($request,Closure $next){
    	return parent::handle($request,$next);
    }

    // Determine if the session and input CSRF Token match 


    protected function tokenMatch($request){

    	// if the request is an ajax request ,then check to see if token matches provider
    	//in the header. this way we can use CSRF protection in ajax request also.
    	$token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');
    	return $request->session()->token() == $token;
    }
}
