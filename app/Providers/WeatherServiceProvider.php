<?php

namespace App\Providers;

use App\Http\Middleware\SingletonProof2;
use App\Services\WeatherDataService;
use App\Services\WeatherDataServiceInterface;
use App\Services\WeatherDataServiceTest;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{

    public array $singletons = [
        WeatherDataServiceInterface::class,
        WeatherDataService::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {

//        $this->app->scoped(WeatherDataServiceInterface::class,  function (){
  //          return new  WeatherDataService($this->app->make(WeatherDataServiceTest::class, [''] ));
    //    });

        $this->app->when(SingletonProof2::class)
            ->needs('$something')
            ->giveConfig('app.name');

        #1
        Config::get('');

        #2
        \config();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
