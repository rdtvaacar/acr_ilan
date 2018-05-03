<?php
Route::group(['middleware' => ['web']], function () {
    Route::group([
        'namespace' => 'Acr\Ilan\Controllers',
        'prefix'    => 'acr/ilan'
    ], function () {
        Route::get('/', 'AcrIlanController@index');
        Route::get('/incele', 'AcrIlanController@incele');
        Route::get('/denetim', 'AcrIlanController@ilan_denetim');
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/yeni', 'AcrIlanController@yeni');
            Route::post('/kaydet', 'AcrIlanController@kaydet');
            Route::post('/sil', 'AcrIlanController@sil');
            Route::get('/cv', 'AcrIlanController@cv');
            Route::post('/basvur', 'AcrIlanController@basvur');
            Route::post('/basvuru/kaldir', 'AcrIlanController@basvuru_kaldir');
            Route::get('/basvurular', 'AcrIlanController@basvurular');
            Route::post('/cv/kaydet', 'AcrIlanController@cv_kaydet');
            Route::post('/county', 'AcrIlanController@county');
            Route::group(['middleware' => ['admin']], function () {
            });
        });
    });
});