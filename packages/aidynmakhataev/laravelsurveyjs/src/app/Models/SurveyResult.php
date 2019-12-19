<?php

namespace AidynMakhataev\LaravelSurveyJs\app\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    protected $table = 'survey_results';
    protected $fillable = [
        'survey_id', 'interview', 'ip_address', 'json',
    ];
    protected $casts = [
        'json'  =>  'array',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo('AidynMakhataev\LaravelSurveyJs\app\Models\Survey', 'survey_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(App\Interview, 'interview');
    }
}
