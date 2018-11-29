<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuoyData extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buoy_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'buoy_id',
	    'wave_height',
	    'dominant_period',
	    'average_period',
	    'angle',
	    'water_temp',
    ];
}
