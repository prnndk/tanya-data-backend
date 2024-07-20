<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(\App\Http\Controllers\AuthController::class)->prefix("auth")->group(function (){
    Route::post('register','register');
    Route::post('login','login');
    Route::get('logout','logout')->middleware(\App\Http\Middleware\Authenticate::class,'auth:sanctum');
    Route::get('me','me')->middleware(\App\Http\Middleware\Authenticate::class,'auth:sanctum');
});

Route::controller(\App\Http\Controllers\EventController::class)->prefix("event")->group(function (){
    Route::get('/','index');
    Route::get('{event:id}','show');
    Route::post('/','store')->middleware(\App\Http\Middleware\Authenticate::class,'auth:sanctum',\App\Http\Middleware\IsAdmin::class);
    Route::put('{id}','update')->middleware(\App\Http\Middleware\Authenticate::class,'auth:sanctum');
    Route::delete('{id}','destroy')->middleware(\App\Http\Middleware\Authenticate::class,'auth:sanctum');
});

Route::controller(\App\Http\Controllers\EventParticipantController::class)->prefix("event-participant")->middleware([\App\Http\Middleware\Authenticate::class,'auth:sanctum'])->group(function (){
    Route::get('/','index');
    Route::get('{event_participant:id}','show');
    Route::prefix('buy')->group(function (){
        Route::post('coaching','buyCoachingClass');
        Route::post('open-class','buyOpenClass');
        Route::post('seminar','buySeminar');
    });
    Route::put('{event_participant:id}','update');
    Route::delete('{event_participant:id}','destroy');
});

Route::controller(\App\Http\Controllers\PackageDataController::class)->prefix('package')->middleware([\App\Http\Middleware\Authenticate::class,'auth:sanctum'])->group(function (){
    Route::get('/','index');
    Route::get('{package_data:id}','show');
    Route::post('/','store')->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::put('{package_data:id}','update')->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::delete('{package_data:id}','destroy')->middleware(\App\Http\Middleware\IsAdmin::class);
});

Route::controller(\App\Http\Controllers\PaymentController::class)->prefix('payment')->middleware([\App\Http\Middleware\Authenticate::class,'auth:sanctum'])->group(function (){
    Route::get('/bank-receiver','getReceiverBank');
    Route::post('/bank-receiver','storeReceiverBank')->middleware(\App\Http\Middleware\IsAdmin::class);
});


