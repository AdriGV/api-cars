<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteSrviceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::resource('cars',CarController::class);

//Public Routes
Route::get('/', [CarController::class, 'show']);
Route::get('/cars/car/{car:id}', [CarController::class, 'find']);
Route::post('/register',[RegisterController::class,'store']);
Route::post('/login',[SessionsController::class,'store']);
Route::get('register/ajax-validarmail',[UserController::class,'validarmail']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/cars/car/eliminar/{car:id}', [CarController::class, 'destroy']);
    Route::patch('/cars/car/editar/{car:id}', [CarController::class, 'update']);
    Route::post('/cars/car/crear', [CarController::class, 'create']);
    Route::get('/cars/marcas', [MarcaController::class, 'showAll']);
    Route::get('/cars/car/comprar/{car:id}', [CarController::class, 'buy']);
    Route::get('/logout',[SessionsController::class,'destroy']);

    Route::get('perfil/eliminar/{user:id}/',[UserController::class,'destroy']);
    Route::get('perfil',[UserController::class,'perfil']);
    Route::patch('perfil/edit/{user:id}',[UserController::class,'update']);
    Route::get('perfil/all/',[UserController::class,'show']);

});
