<?php
Route::group(['middleware' => ['web']], function () {
    Route::group([
        'namespace' => 'Acr\Ilan\Controllers',
        'prefix'    => 'acr/ilan'
    ], function () {
        Route::get('/', 'AcrIlanController@index');
        Route::group(['middleware' => ['auth']], function () {
            Route::group(['middleware' => ['admin']], function () {
            });
        });
    });
});