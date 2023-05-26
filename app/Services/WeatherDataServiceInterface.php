<?php

namespace App\Services;

interface WeatherDataServiceInterface
{
    public function getData(): object;

    public  function setSomething(string $something);
}
