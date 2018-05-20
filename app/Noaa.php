<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noaa extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'noaa_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'location_id',
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
