<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        // $ip =  $request->ip();
        $key = "gYCHqT7Al60y1pw";
        $ip = "92.98.57.182";

        $data = json_decode(file_get_contents("https://pro.ip-api.com//json/$ip?key=$key"));

        if($data->country & $data->city & $data->countryCode){
            return response()->json($data);
        }else{
            $key = "MVz6oqMIVZmrSekBA52O";
            $data = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$ip?key=$key"));
            return response()->json($data);
        }

    }


    
}
