<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    //
    protected $fillable = ['name', 'res_d', 'phone', 'phone1','phone2','phone3', 'email', 'occupation', 'county', 'town', 'education', 'sex', 'lsm', 'age', 'status', 'project'];
}
