<?php

namespace App\Http\Middleware;

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
        if(!empty($data)){
            $city = $data->city;
            $country = $data->country; 
            $countryCode = $data->countryCode; 
            $isp = $data->isp; 
            $org = $data->org; 
            $query = $data->query; 
            $region = $data->region; 
            $timezone = $data->timezone; 
            $provider = isset($data->businessName) ? 'extreme' : 'ip-api';
    
            $log = "{$city},{$country},{$countryCode},{$isp}, {$org},{$query},{$region},{$timezone},{$provider}";
    
            Log::channel('daily')->info($log);
        }
    }
}