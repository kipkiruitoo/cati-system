<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spedule extends Model
{
    //


    public function agent()
    {
        return $this->belongsTo('App\User');
    }

    public function respondent()
    {
        return $this->belongsTo('App\Respondent');
    }

    protected $fillable = ['schedule', 'date', 'time', 'user_id'];
}
