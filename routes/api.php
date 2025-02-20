<?php

use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

$apis = Api::all();

foreach ($apis as $api) {
    Route::match([$api->method], $api->endpoint, function () use ($api) {
        return response()->json(json_decode($api->response, true));
    })->name('admin.' . str_replace('/', '.', trim($api->endpoint, '/')));
}

