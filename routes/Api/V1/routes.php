<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'App\Http\Controllers\Api\V1\Auth', 'prefix' =>'auth'],function ($router){
    $router->namespace('Email')->prefix('email')->group(function ($router) {
        $router->post('/register','AuthController@register');
        $router->post('/login','AuthController@login');
        $router->post('/reset-password', 'AuthController@reset_password')->name('password.reset');
        $router->post('/forgot-password', 'AuthController@forgot_password')->middleware('guest');
        $router->get('/verify-email', 'AuthController@verify_email')->middleware('signed')->name('verification.verify'); // verification.verify name is used to map the email with "Registered" event in RegisterController.

        /* Routes with sanctum authentication middleware */
        $router->middleware('auth:sanctum')->group(function ($router) {
            $router->post('/logout', 'AuthController@logout');
            $router->get('/user', 'UserController@index');
            $router->post('resend-verify-email', 'AuthController@resend_verify_email');
        });
    });
});

// Route::group(['namespace' => 'App\Http\Controllers\Api\V1'],function ($router){
    
//     /* Routes with sanctum authentication middleware */
//     $router->middleware('auth:sanctum')->apiResource('blogs', BlogController::class);
   
// });


JsonApiRoute::server('v1')->middleware('auth:sanctum')->namespace('App\Http\Controllers\Api\V1')->resources(function (ResourceRegistrar $server) {
    $server->resource('blogs', BlogController::class);
    $server->resource('places', PlaceController::class);

});