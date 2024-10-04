<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $user = $request->user();
        if(!$user){
            return redirect()->route('login');
        }
        if ($user->type != $type){
            //return abort(403);
            return redirect('https://cdn.dribbble.com/users/2449060/screenshots/6787406/403_2x_2x.png');
        }
        return $next($request);

    }
}
