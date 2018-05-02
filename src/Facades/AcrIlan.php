<?php

namespace Acr\Ilan\Facades;

use Illuminate\Support\Facades\Facade;

class AcrIlan extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AcrIlan';
    }

}