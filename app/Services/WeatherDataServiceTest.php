<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherDataServiceTest implements WeatherDataServiceInterface{

    private  static int $times ;
    private string $something = "MAREMMA";

    public function __construct() {

        if (!isset(self::$times))
            self::$times = 0;
        else
            self::$times++;

    }

    public function getData(): object {

        $data = new \stdClass();

        $data->weather = new \stdClass();
        $data->weather->description = "MAREMMA";
        $data->weather->times = self::$times ;
        $data->weather->somethingIs = $this->something;


        return $data;
    }

    public function setSomething(string $something){

        $this->something = $something;
    }
}
