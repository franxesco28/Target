<?php

namespace App\Http\Middleware;

use App\Services\WeatherDataServiceInterface;
use App\Services\WeatherDataServiceTest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingletonProof
{

    public function __construct(WeatherDataServiceInterface $weather_service) {
        $this->weather_service = $weather_service;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->weather_service->getData();
        $this->weather_service->getData();
        $this->weather_service->getData();
        $this->weather_service->getData();
        $this->weather_service->getData();
        $this->weather_service->getData();

        return $next($request);
    }
}
