<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        $ip =  $request->ip();
        $key = "gYCHqT7Al60y1pw";
        // $ip = "92.98.57.182";   
        // $ip = "103.92.154.254";
        try {
            $data = json_decode(file_get_contents("https://pro.ip-api.com//json/$ip?key=$key"));
        } catch (\Throwable $th) {
            Log::channel('stack')->warning("warning;ip-api Failed");
        }
    

        if(!empty($data->country) & !empty($data->city) & !empty($data->countryCode)){
            return response()->json($data);
        }else{
            Log::channel('stack')->warning("warning;ip-api Failed;No data found which needed");
            $key = "MVz6oqMIVZmrSekBA52O";
            
            try {
                $data = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$ip?key=$key"));
            } catch (\Throwable $th) {
                Log::channel('stack')->error("error;Extreme Failed");
            }

            if(!empty($data->country) & !empty($data->city) & !empty($data->countryCode)){
                return response()->json($data);
            }else{
                Log::channel('stack')->error("error;Extreme Failed");
            } 
        }

    }

    public function getLocationPost (Request $request)
    {
        $ip =  $request->ip();
        $key = "gYCHqT7Al60y1pw";
        // $ip = "92.98.57.182";   
        // $ip = "103.92.154.254";
        try {
            $data = json_decode(file_get_contents("https://pro.ip-api.com//json/$ip?key=$key"));
            
        } catch (\Throwable $th) {
            Log::channel('stack')->warning("warning;ip-api Failed");
        }
    

        if(!empty($data->country) & !empty($data->city) & !empty($data->countryCode)){
            $rawdata = file_get_contents("php://input");
            $decoded = json_decode($rawdata);
            $data->app_name = $decoded->app_name;
            $data->device_id = $decoded->device_id;
            $data->app_version = $decoded->app_version;
            return response()->json($data);
        }else{
            Log::channel('stack')->warning("warning;ip-api Failed;No data found which needed");
            $key = "MVz6oqMIVZmrSekBA52O";
            
            try {
                $data = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$ip?key=$key"));
            } catch (\Throwable $th) {
                Log::channel('stack')->error("error;Extreme Failed");
            }

            if(!empty($data->country) & !empty($data->city) & !empty($data->countryCode)){
                $rawdata = file_get_contents("php://input");
                $decoded = json_decode($rawdata);
                $data->app_name = $decoded->app_name;
                $data->device_id = $decoded->device_id;
                $data->app_version = $decoded->app_version;
                return response()->json($data);
            }else{
                Log::channel('stack')->error("error;Extreme Failed");
            } 
        }
    }

    public function post()
    {
        return view('post');
    }
}
