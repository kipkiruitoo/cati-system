<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    //
    protected $fillable = ['name', 'res_d','phone', 'email','occupation','county','town','education','sex','lsm','age','status'];
}
