<?php

namespace Acr\Ilan\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ilan extends Model

{
    use SoftDeletes;

    function city()
    {
        return $this->belongsTo('App\City');
    }

    function county()
    {
        return $this->belongsTo('App\County');
    }

    function user()
    {
        return $this->belongsTo('App\User');
    }

    function basvurular()
    {
        return $this->hasMany('Acr\Ilan\Model\Ilan_basvuru','ilan_id','id');
    }
}
