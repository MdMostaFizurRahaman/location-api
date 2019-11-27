<?php

namespace App\Http\Middleware;

use Closure;
use App\Statistic;

class InsertResponse
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request->end = microtime(true);

        $this->insert($request,$response);
    }



    protected function insert($request,$response)
    {

        $data = json_decode($response->getContent());
        if(isset($data->country) & isset($data->city)){
           
            $statistic = new Statistic();

            $statistic->insert([
                'city'          => $data->city,
                'country'       => $data->country,
                'countryCode'   => $data->countryCode,
                'isp'           => $data->isp,
                'org'           => $data->org,
                'query'         => $data->query,
                'region'        => $data->region,
                'timezone'      => $data->timezone,
            ]);
        }
    }
}
