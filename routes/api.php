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

});




