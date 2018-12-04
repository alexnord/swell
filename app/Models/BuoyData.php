<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Carbon\Carbon;

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

    protected $casts = [
        'swell_direction' => 'string',
    ];

    protected $appends = [
        'swell_direction',
        'observation_time',
        'buoy_name'
    ];

    public function buoy()
    {
        return $this->belongsTo('App\Models\Buoy', 'buoy_id');
    }

    public function getSwellDirectionAttribute()
    {
        return $this->attributes['swell_direction'] = Helper::getDirection($this->angle);
    }

    public function getObservationTimeAttribute()
    {
        $cb = new Carbon($this->timestamp);
        $cb->tz = 'America/Los_Angeles';
        return $this->attributes['observation_time'] =$cb->toDayDateTimeString();
    }

    public function getBuoyNameAttribute()
    {
        return $this->attributes['buoy_name'] = $this->buoy->title;
    }
}
