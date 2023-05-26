<?php

use App\Models\User;
use App\Services\WeatherDataService;
use App\Services\WeatherDataServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/greeting',function (){
    return 'A mia ma suchi';
});

/*Route::get('/user/{id}/some/{name}', function (Request $request,$id, $name) {

  dd($request);

  return 'USER ' . $id . '-' . $name;
});*/

/*Route::prefix('menu')
    ->name('menu.')
    ->group(function () {

        Route::get('/{id}', function (Request $request, $id) {
            return 'Menu' . $id;
        })->name('get');
        Route::get('/item/{id}', function (Request $request, $id) {
            return 'Menu.item' . $id;
        })->name('get.item');
    });
*/

#number e alpha
/*Route::get('/user/{id}/some/{name?}', function (Request $request,$id, $name ) {
    return 'User ' . $id . '-' . $name;
})->where('name','[A-Za-z]+') // whereAlpha
    ->where('id' ,'[0-9]+')// whereNumber
    ;
*/

#where in
/*Route::get('/film/{category}', function ($category ) {
    return 'Film' .  $category;
})->whereIn('category',['commedia','horror','dramma']);
*/

#vincolo pattern
/*
Route::get('/user/{id}', function (Request $request,$id ) {
    return 'User ' . $id;
});

Route::get('/menu/{id}', function (Request $request,$id ) {
    return 'Menu ' . $id;
});

Route::get('/menu/item/{id}', function (Request $request,$id ) {
    return 'Menu ' . $id;
});*/

#vincolo name
Route::get('/user/{id}', function (Request $request,$id ) {
    return 'User ' . $id;
})->name('getUser');

Route::get('/menu/{id}', function (Request $request,$id ) {
    return 'Menu ' . $id;
})->name('getMenu');

Route::get('/menu/item/{id}', function (Request $request,$id ) {
    return redirect()->route('getMenu', ['id' => $id]);
})->name('getMenuItem');

Route::get('route/info', function (){
    dd(Route::current());
});


Route::prefix('menu')
    ->name('menu.')
    ->group(function (){

        Route::get('/{id}', function (\Illuminate\Http\Client\Request $request, $id ){ return 'Menu '. $id ;} )->name('get');
        Route::get('/item/{id}', function (Request $request, $id ){
            return'Menu item ' . $id;
        })->name('get.item');

    });

Route::get('/user/code/{id}',function(User $user){
    return $user;
})->missing(fn() => \Illuminate\Support\Facades\Redirect::route('user.index'));

Route::get('/user/{user}',function (Request $request,User $user){
    return new \Illuminate\Http\JsonResponse($user,201);
})
    ->name('getUser')
    ->missing(fn() => \Illuminate\Support\Facades\Redirect::route('user.index'));

Route::get('meteo/data', function (WeatherDataServiceInterface $data_service){
   return  $data_service->getData();
});


Route::get('weather/data', function (){

    # ANTI PATTERN SERVICE PROVIDER
   $weather_service = App::make(WeatherDataServiceInterface::class);

    $d = $weather_service->getData();

    return $d;
});

#LECTURES

Route::get('lecturers/{day}', function (string $day){

    $viewName = 'lecturers.indexxx';
//  return View::make($viewName, ['name' => $day]);

// if (View::exists($viewName)){
//     return View::make($viewName, ['name' => $day]);
//  }

    return View::make('lecturers.index')
        ->with('name', $day )
        ->with('pippo',0);

});
