<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Client;
use App\Employee;
use App\Restaurant;
use Carbon\Carbon;

class Subscription
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
        $today = Carbon::today();
        if(Auth::check()) {
            if(Auth::user()->role_id > 1) {
                if(Auth::user()->role_id == 2) {
                    $client = Client::where('email', Auth::user()->email)->first();
                    $end = Carbon::parse($client->package_at)->addMonths($client->packageInfo->no_of_months); 
                } else if(in_array(Auth::user()->role_id, [3,4,5])) {
                    $client = Employee::where('user_id', Auth::user()->id)->first()->restaurantInfo->clientInfo;
                    $end = Carbon::parse($client->package_at)->addMonths($client->packageInfo->no_of_months);                 
                }
                if( $today >= $end ){
                    return redirect('subscription');
                }
            }
        }
        if ($request->route('url')) {
            $client = Restaurant::where('url', $request->route('url'))->first()->clientInfo;
            $end = Carbon::parse($client->package_at)->addMonths($client->packageInfo->no_of_months);
            if( $today >= $end ){
                return redirect('404');
            }
        }
        return $next($request);
    }
}
