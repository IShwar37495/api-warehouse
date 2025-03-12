<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiDocsController;
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
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

});


//admin routes-->

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function(){
 Route::get('/create-api', [AdminController::class, 'createApi'])->name('api.create');
 Route::post('/store-api', [AdminController::class,'storeApi'])->name('api.store');
});


//accessing the apis demo page


Route::middleware(['auth'])->prefix('api-page')->as('apiPage.')->group(function(){

Route::get('/countries',[ApiPageController::class, "allcountriesApiPageDemo"])->name('countries');

Route::get('/auth-user', [ApiPageController::class, 'authUserApiPageDemo'])->name('authUser');

});


Route::middleware(['auth'])->prefix('user')->as('user.')->group(function(){

    Route::post('/photo',[UserController::class, "addProfilePic"])->name('addProfilePic');

    Route::get('/chat', [UserController::class, 'showChatPage'])->name('showChatPage');

    });

//auth routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);


//docs routes
Route::middleware(['auth'])->prefix('api-docs')->as('api-docs.')->group(function(){

    Route::get('/auth', [ApiDocsController::class, 'authApiDocs'] )->name('auth');



    });






