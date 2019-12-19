<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $fillable = ['name', 'type'];

    public function type()
    {
        return $this->belongsTo('App\MediaType');
    }
}
