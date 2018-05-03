<?php

namespace Acr\Ilan\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ilan_basvuru extends Model

{
    use SoftDeletes;

    protected $table = 'ilan_basvuru';

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function cv()
    {
        return $this->belongsTo('Acr\Ilan\Model\Ilan_cv');
    }
}
