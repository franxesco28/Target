<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

class OrderItem {

    public string $name;

    public float $price;

    public function __construct(string $name, string $price)
    {
        $this->name= $name;
        $this->price = $price;

    }
}

Route::get('/carello',function (Request $request){
    return [
        new OrderItem('PC',1550),
        new OrderItem('Mouse',130),
        new OrderItem('Tablet',1430),
    ];
});
