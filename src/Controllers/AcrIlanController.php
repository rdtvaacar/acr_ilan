<?php

namespace Acr\Ilan\Controllers;

use App\User;
use Auth;

class AcrIlanController
{
    function index()
    {
        $user_model = new User();
        return View('acr_ilan::index');
    }
}