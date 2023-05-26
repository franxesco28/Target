<?php

namespace App\Services;

class WeatherDataService implements WeatherDataServiceInterface
{



    public function getData(): object {

        //TODO : chiamata ad un servizio API che ritorna dati meteo

        $data = new \stdClass();
        $data->weather = new \stdClass();
        $data->weather->id = 802 ;
        $data->weather->main = "Clouds";
        $data->weather->description = "scattered clouds";
        $data->weather->icon = "03n";

        return $data;

    }

    public function setSomething(string $something)
    {
        //TODO : implement setSomething() method
    }
}


