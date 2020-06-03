<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    public function supervisors()
    {
        return $this->belongsToMany(User::class);
    }
    public function project_manager()
    {
        return $this->belongsTo(User::class, 'pm');
    }
    public function respondents()
    {
        return $this->hasMany('App\Respondent');
    }

    public function calls()
    {
        return $this->hasManyThrough('App\Call', 'App\Respondent', 'project', 'respondent');
    }

    public function feedbacks()
    {
        return $this->hasManyThrough('App\Feedback', 'App\Respondent', 'project', 'respondent_id');
    }
}
