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
            Log::channel('stack')->warning("ip-api Failed");
        }
    

        if(isset($data->country) & isset($data->city) & isset($data->countryCode)){
            return response()->json($data);
        }else{
            Log::channel('stack')->warning("ip-api Failed, No data found which needed.");
            $key = "MVz6oqMIVZmrSekBA52O";
            
            try {
                $data = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$ip?key=$key"));
            } catch (\Throwable $th) {
                Log::channel('stack')->error("Both Failed");
            }

            if(isset($data->country) & isset($data->city) & isset($data->countryCode)){
                return response()->json($data);
            }else{
                Log::channel('stack')->error("Both Failed");
            } 
        }

    }


    public function readLog()
    {
        $file =null;
        try {
            $file = fopen(storage_path('logs/api/laravel-2019-11-27.log'),"r") or die("Error");
        } catch (\Throwable $th) {
            //throw $th;
        }

        $pattern= '/\[\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}\]\s\w*.INFO:/';

        if($file){  
            while(($row = fgets($file)) != false) {
                
                $row = preg_replace($pattern, "", $row);

                $cols = explode(',', $row);
    
                foreach($cols as $col){
                    echo "<li>". $col."</li>";
                }
            }
        }else{
            return response("0", 404);  
        }

    }
}
