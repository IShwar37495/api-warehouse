<?php

use App\Http\Controllers\ApiController;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// $apis = Api::all();

// foreach ($apis as $api) {
//     Route::match([$api->method], $api->endpoint, function () use ($api) {
//         return response()->json(json_decode($api->response, true));
//     })->name('admin.' . str_replace('/', '.', trim($api->endpoint, '/')));
// }



Route::middleware(['auth:sanctum'])->prefix('/v1')->group(function(){

    Route::get('/indian-states', [ApiController::class, "indianStates"])->name('api.indianStates');


  // countries api routes
    Route::get('/countries',[ApiController::class, "allCountries"])->name('api.allCountries');

    //auth api routes

    Route::post('/register-user', [ApiController::class, 'registerUser'])->name('api.registerUser');

    Route::post('/login-user', [ApiController::class, 'loginUser'])->name('api.loginUser');

    Route::post('/validate-token', [ApiController::class, 'validateToken'])->name('api.validateToken');

    Route::post('/refresh-token', [ApiController::class, 'refreshToken'])->name('api.refreshToken');

});




