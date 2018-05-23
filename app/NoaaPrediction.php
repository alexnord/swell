<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoaaPrediction extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'noaa_predictions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'noaa_station_id',
        'timestamp',
        'swell_direction',
	    'swell_height',
	    'swell_period',
	    'wave_direction',
	    'wave_height',
	    'wave_period',
	    'wind_direction',
	    'wind_speed',
    ];
}
