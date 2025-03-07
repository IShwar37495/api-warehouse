<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


//admin routes-->

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function(){

 Route::get('/create-api', [AdminController::class, 'createApi'])->name('api.create');

 Route::post('/store-api', [AdminController::class,'storeApi'])->name('api.store');

});


//accessing the apis demo page


Route::middleware(['auth'])->prefix('api-page')->as('apiPage.')->group(function(){

Route::get('/countries',[ApiPageController::class, "allcountriesApiPageDemo"])->name('countries');

});


Route::middleware(['auth'])->prefix('user')->as('user.')->group(function(){

    Route::post('/photo',[UserController::class, "addProfilePic"])->name('addProfilePic');

    Route::get('/chat', [UserController::class, 'showChatPage'])->name('showChatPage');

    });






