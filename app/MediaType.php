<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $fillable = ['name', 'id'];

    protected $table = 'media_type';

    public function media()
    {
        return $this->hasMany('App\Media');
    }
}
