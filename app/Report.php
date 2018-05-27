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

        'start_time',
        'end_time',

        'location_id',

        'start_swell_dir',
        'start_swell_angle',
        'start_swell_height',
        'start_swell_period',

        'end_swell_dir',
        'end_swell_angle',
        'end_swell_height',
        'end_swell_period',

        'start_wind_dir',
        'start_wind_angle',
        'start_wind_speed',

        'end_wind_dir',
        'end_wind_angle',
        'end_wind_speed',

        'tide_dir',
        'start_tide_height',
        'end_tide_height',

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

    public function conditions()
    {
        return $this->belongsTo('App\Condition', 'condition_id');
    }
}
