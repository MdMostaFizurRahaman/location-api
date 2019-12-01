<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle($request, Closure $next)
    {
        $request->start = microtime(true);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request->end = microtime(true);

        $this->log($request,$response);
    }

    protected function log($request,$response)
    {

        $data = json_decode($response->getContent());
        if(isset($data->country) & isset($data->city) & isset($data->isp)){
            $city = $data->city;
            $country = $data->country; 
            $countryCode = $data->countryCode; 
            $isp = $data->isp; 
            $org = $data->org; 
            $query = $data->query; 
            $region = $data->region; 
            $timezone = $data->timezone; 
            $provider = isset($data->businessName) ? 'extreme' : 'ip-api';
            $logTime = Carbon::now();
            $log = "{$city},{$country},{$countryCode},{$isp}, {$org},{$query},{$region},{$timezone},{$provider},{$logTime}";
            Log::channel('daily')->info($log);
        }
    }
}