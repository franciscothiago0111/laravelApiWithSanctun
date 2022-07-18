<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRequestRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {     
        $user = $request->user();         
           
        if (!$user->tokenCan('write')) {
            return response([
                'message' => 'The token provided is not writeable, please contact our support for more details.',            
            ], 401);
        } 
        
        return $next($request);       
    }      
    
}
