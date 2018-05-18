<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'user_id',
        'date',
        'time',
        'location_id',
        'swell_dir_id',
        'swell_angle',
        'swell_height',
        'swell_period',
        'wind_dir_id',
        'wind_speed',
        'tide_dir_id',
        'tide_height',
        'actual_surf_height',
        'condition_id',
        'score',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function swellDir()
    {
        return $this->belongsTo('App\Direction');
    }

    public function windDir()
    {
        return $this->belongsTo('App\Direction');
    }

    public function tideDir()
    {
        return $this->belongsTo('App\Tide');
    }

    public function conditions()
    {
        return $this->belongsTo('App\Condition', 'condition_id');
    }
}
