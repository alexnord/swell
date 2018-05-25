<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'location_id',
	    'direction',
	    'speed',
    ];
}
