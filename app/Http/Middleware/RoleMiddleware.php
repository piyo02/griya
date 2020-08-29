<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleName)
    {
        if ( $request->expectsJson()) {
            $roleNames = explode( "|", $roleName );
            foreach( $roleNames as $roleName )
            {
                if( $request->user()->hasRole($roleName) )
                {
                    return $next($request);
                }
            }
            $response = [
                'success' => FALSE,
                'data'    => NULL,
                'message' => 'not role',
            ];
            return response()->json( $response , 200 );
        }
        $roleNames = explode( "|", $roleName );
        foreach( $roleNames as $roleName )
        {
            if( $request->user()->hasRole($roleName) )
            {
                return $next($request);
            }
        }
        Auth::logout();
        Session::flush();
        return redirect( route('login') );  
    }
}
