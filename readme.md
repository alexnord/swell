## About Swell Diaries

[http://surf.alexnordlinger.com](http://surf.alexnordlinger.com)

This application allows a user to upload surfing reports after a session. Swell, tide, buoy, and wind conditions are automatically scraped via APIs across the web so that this data is automatically input when submitting a report. As of this version, only locations in the SoCal area are supported.

<div style="display: flex;">
  <img src="https://d1vqe4bnlv6mwq.cloudfront.net/location.png" width="49%" />
  <img src="https://d1vqe4bnlv6mwq.cloudfront.net/report.png" width="49%" />
</div>

### Data is pulled from

- [NOAA](https://www.ndbc.noaa.gov/) (Buoys)
- [StormGlass](https://www.stormglass.io/) (NOAA predictions)
- [DarkSky](https://darksky.net) (Weather)
- [NDBC](https://www.ndbc.noaa.gov/) (Tide)

### Predictions

An hourly breakdown of predictions for swell, tide and wind are available for each location.

### Requirements

* PHP 7+
* Node 6+

### Installation

Clone this repo and run
```bash
$ composer install
$ php artisan migrate --seed
$ npm run dev
$ php artisan serve
```

To enabled API scraping, you must register the Laravel scheduler cron:
```bash
$ * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Admin Access

Visit the admin page at `/admin`

### Server Commands

* Scrape NDBC buoy data
```bash
$ php artisan data:ndbc
```
* Scrape data from Stormglass for NOAA wave predictions.
```bash
$ php artisan data:predictions
```
* Scrape tide predictions from NOAA tide and currents API.
```bash
$ php artisan data:tides
```
* Get weather data via an external API.
```bash
$ data:weather
```


### Packages used

* Laravel 5.7
* VueJS

