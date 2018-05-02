<?php

namespace Acr\Ilan;

use Acr\Ilan\Controllers\AcrIlanController;
use Illuminate\Support\ServiceProvider;

class AcrIlanServiceProviders extends ServiceProvider
{
    public function boot()
    {
        include(__DIR__ . '/routes.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'acr_ilan');
    }

    public function register()
    {
        $this->app->bind('AcrIlan', function () {
            return new AcrIlanController();
        });
    }
}