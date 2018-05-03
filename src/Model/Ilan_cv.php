<?php

namespace Acr\Ilan\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ilan_cv extends Model

{
    use SoftDeletes;

    function user()
    {
        return $this->belongsTo('App\User');
    }
}
