<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TideData extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tide_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'type',
        'height',
    	'noaa_station_id',
    ];
}
