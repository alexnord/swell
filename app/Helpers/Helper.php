<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Helper
{

    public function __construct()
    {

    }

    public static function getDirection($angle)
    {
        switch(true) {
            case ($angle > 348.75):
                $dir = 'N';
                break;
            case ($angle < 11.25):
                $dir = 'N';
                break;
            case ($angle > 11.25 && $angle < 33.75):
                $dir = 'NNE';
                break;
            case ($angle > 33.75 && $angle < 56.25):
                $dir = 'NE';
                break;
            case ($angle > 56.25 && $angle < 78.75):
                $dir = 'ENE';
                break;
            case ($angle > 78.75 && $angle < 101.25):
                $dir = 'E';
                break;
            case ($angle > 101.25 && $angle < 123.75):
                $dir = 'ESE';
                break;
            case ($angle > 123.75 && $angle < 146.25):
                $dir = 'SE';
                break;
            case ($angle > 146.25 && $angle < 168.75):
                $dir = 'SSE';
                break;
            case ($angle > 168.75 && $angle < 191.25):
                $dir = 'S';
                break;
            case ($angle > 191.25 && $angle < 213.75):
                $dir = 'SSW';
                break;
            case ($angle > 213.75 && $angle < 236.25):
                $dir = 'SW';
                break;
            case ($angle > 236.25 && $angle < 258.75):
                $dir = 'WSW';
                break;
            case ($angle > 258.75 && $angle < 281.25):
                $dir = 'W';
                break;
            case ($angle > 281.25 && $angle < 303.75):
                $dir = 'WNW';
                break;
            case ($angle > 303.75 && $angle < 326.25):
                $dir = 'NW';
                break;
            case ($angle > 326.25 && $angle < 348.75):
                $dir = 'NNW';
                break;
            default:
                $dir = 'NA';
                break;
        }

        return $dir;
    }
}
