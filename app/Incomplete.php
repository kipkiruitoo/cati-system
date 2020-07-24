<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incomplete extends Model
{
    public function agent()
    {
        return $this->belongsTo('App\User', 'agent');
    }
    protected $table = 'incomplete';
}
