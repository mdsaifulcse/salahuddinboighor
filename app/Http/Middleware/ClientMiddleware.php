<?php

namespace App\Http\Middleware;

use Closure;

class ClientMiddleware
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

        if(\Auth::check() && \Auth::user()->roles[0]->name=='general-customer')
        {
            redirect('/account/account');
        }else{

            \Auth::logout();
            return  redirect('/login/admin')->with('error','As a admin please login here');
        }


        return $next($request);
    }
}
