<?php

namespace App\Http\Middleware;

use Closure;

class CheckHost
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
        $host = str_after($_SERVER['HTTP_HOST'],'.');
        $dbyuming =  \Illuminate\Support\Facades\DB::table('yuming')->select('host')->get()->toArray();
        foreach ($dbyuming as $item){
            if ($host == $item->host){
                $yuming = $item->host;
                $request->attributes->add($yuming);
            }
        }


        return $next($request);
    }

}
