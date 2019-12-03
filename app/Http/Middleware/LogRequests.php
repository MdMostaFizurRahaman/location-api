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
        if(!empty($data->country) & !empty($data->city) & !empty($data->isp)){
            $city = $data->city;
            $country = $data->country; 
            $countryCode = $data->countryCode; 
            $isp = $data->isp; 
            $org = $data->org; 
            $query = $data->query; 
            $region = $data->region; 
            $timezone = $data->timezone; 
            $provider = !empty($data->businessName) ? 'extreme' : 'ip-api';
            $logTime = Carbon::now();
            $app_name = !empty($data->app_name) ? $data->app_name : '';
            $device_id = !empty($data->device_id) ? $data->device_id : '';
            $app_version = !empty($data->app_version) ? $data->app_version : '';
            $log = "{$city};{$country};{$countryCode};{$isp};{$org};{$query};{$region};{$timezone};{$provider};{$logTime};{$app_name};{$device_id};{$app_version};";
            Log::channel('daily')->info($log);
        }
    }
}