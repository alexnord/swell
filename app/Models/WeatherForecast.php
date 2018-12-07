<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Carbon\Carbon;

class WeatherForecast extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_forecasts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timestamp',
        'location_id',
	    'text',
	    'icon',
        'temperature',
        'angle',
        'speed',
    ];

    protected $appends = [
        'wind_direction',
        'observation_time',
        'location_name'
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    public function getWindDirectionAttribute()
    {
        return $this->attributes['wind_direction'] = Helper::getDirection($this->angle);
    }

    public function getObservationTimeAttribute()
    {
        $cb = new Carbon($this->timestamp);
        $cb->tz = 'America/Los_Angeles';
        return $this->attributes['observation_time'] =$cb->toDayDateTimeString();
    }

    public function getLocationNameAttribute()
    {
        if (isset($this->location->title)) {
            return $this->attributes['location_name'] = $this->location->title;
        } else {
            return '';
        }
    }
}
