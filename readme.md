## About Swell Diaries

[http://surf.alexnordlinger.com](http://surf.alexnordlinger.com)

This application allows a user to upload surfing reports after a session. Swell, tide, buoy, and wind conditions are automatically scraped via APIs across the web so that this data is automatically input when submitting a report. As of this version, only locations in the SoCal area are supported.

### Data is pulled from

- [NOAA](https://www.ndbc.noaa.gov/) (Buoys)
- [StormGlass](https://www.stormglass.io/) (NOAA predictions)
- [DarkSky](https://darksky.net) (Weather)
- [NDBC](https://www.ndbc.noaa.gov/) (Tide)

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

### Predictions

An hourly breakdown of predictions for swell, tide and wind are available for each location.

### Requirements

PHP 7+
Node 6+

### Installation

Clone this repo and run
```bash
$ composer install
$ php artisan migrate --seed
$ php artisan serve
```

### Admin Access

Visit the admin page at `/admin`


### Packages used

Laravel 5.7

