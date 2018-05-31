<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Carbon\Carbon;

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

    protected $appends = [
        'formatted_date',
        'formatted_start_time',
        'formatted_end_time',

        'avg_swell_angle',
        'avg_swell_dir',
        'avg_swell_height',
        'avg_swell_period',

        'avg_wind_speed',
        'avg_wind_angle',
        'avg_wind_dir',
    ];

    public function getFormattedDateAttribute($value)
    {   
        $dt = Carbon::parse($this->date);
        return $dt->format('l, F jS Y');  
    }

    public function getFormattedStartTimeAttribute($value)
    {   
        $t = Carbon::parse($this->start_time);
        return $t->format('g:i A');
    }

    public function getFormattedEndTimeAttribute($value)
    {   
        $t = Carbon::parse($this->end_time);
        return $t->format('g:i A');
    }

    public function getAvgSwellAngleAttribute($value)
    {
        $avgSwellAngle = $this->end_swell_angle ?
                ($this->start_swell_angle + $this->end_swell_angle)/2 :
                $this->start_swell_angle;
            $avgSwellDir = Helper::getDirection($avgSwellAngle);
        
        return $avgSwellAngle;
    }

    public function getAvgSwellDirAttribute($value)
    {
        return Helper::getDirection($this->avg_swell_angle);
    }

    public function getAvgSwellHeightAttribute($value)
    {
        $avgSwellHeight = $this->end_swell_height ? 
                ($this->start_swell_height + $this->end_swell_height)/2 :
                $this->start_swell_height;

        return $avgSwellHeight;
    }

    public function getAvgSwellPeriodAttribute($value)
    {
        $avgSwellPeriod = $this->end_swell_period ? 
                ($this->start_swell_period + $this->end_swell_period)/2 :
                $this->start_swell_period;

        return $avgSwellPeriod;
    }

    public function getAvgWindSpeedAttribute($value)
    {
        $avgWindSpeed = $this->end_wind_speed ? 
                ($this->start_wind_speed + $this->end_wind_speed)/2 :
                $this->start_wind_speed;
        
        return $avgWindSpeed;
    }

    public function getAvgWindAngleAttribute($value)
    {
        $avgWindAngle = $this->end_wind_angle? 
                ($this->start_wind_angle + $this->end_wind_angle)/2 :
                $this->start_wind_angle;
        
        return $avgWindAngle;
    }

    public function getAvgWindDirAttribute($value)
    {
        return Helper::getDirection($this->avg_wind_angle);
    }

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
