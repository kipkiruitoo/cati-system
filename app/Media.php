<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    protected $fillable = ['name', 'media_type_id'];

    public function type()
    {
        return $this->belongsTo('App\MediaType');
    }
}
