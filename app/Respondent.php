<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{

    public function project()
    {
        return $this->belongsTo('App\Projects', 'projects');
    }
    public function calls()
    {
        return $this->hasMany('App\Calls');
    }

    public function spedules()
    {
        return $this->hasMany('App\Spedule');
    }


    public function interviews()
    {
        return $this->hasMany('App\Interview', 'respondent');
    }

    public function incomplete()
    {
        return $this->hasMany('App\Incomplete', 'respondent');
    }


    protected $fillable = ['name', 'res_d', 'phone', 'phone1', 'phone2', 'phone3', 'email', 'occupation', 'county', 'town', 'education', 'sex', 'lsm', 'age', 'status', 'project', 'district', 'division', 'sublocation', 'location', 'ward'];
}
