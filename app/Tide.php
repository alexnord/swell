<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tide extends Model
{
    use Searchable;

    public function report()
    {
        return $this->belongsTo('App\Report');
    }
}
