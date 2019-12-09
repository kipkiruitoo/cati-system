<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    public function supervisors()
    {
        return $this->belongsToMany(User::class);
    }
}
