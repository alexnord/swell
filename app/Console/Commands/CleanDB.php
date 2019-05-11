<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\BuoyData;
use App\Models\NoaaPrediction;
use App\Models\WeatherForecast;
use App\Models\WeatherData;

class CleanDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean out the DB of old records. Removes from: buoy_data, noaa_predictions, weather_data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $bar = $this->output->createProgressBar(4);
        
        // Delete buoy_data records
        $result = $this->deleteBuoyDataRecords($thirtyDaysAgo, $bar);

        // Delete noaa_predictions records
        $result = $this->deleteNoaaPredictionRecords($thirtyDaysAgo, $bar);

        // Delete weather_forecasts records
        $result = $this->deleteWeatherForecastRecords($thirtyDaysAgo, $bar);

        // Delete weather_data records
        $result = $this->deleteWeatherDataRecords($thirtyDaysAgo, $bar);

        $bar->finish();
        return true;
    }

    private function deleteBuoyDataRecords(\Carbon\Carbon $olderThan, $bar)
    {
        $bar->advance();
        $this->info("\nDeleting buoy_data records older than $olderThan");

        $records = BuoyData::where('timestamp', '<', $olderThan)->get();
        foreach ($records as $record) {
            try {
                BuoyData::find($record->id)->delete();
            } catch(Exception $e) {
                continue;
            }
        }

        return true;
    }

    private function deleteNoaaPredictionRecords(\Carbon\Carbon $olderThan, $bar)
    {
        $bar->advance();
        $this->info("\nDeleting noaa_prediction records older than $olderThan");

        $records = NoaaPrediction::where('timestamp', '<', $olderThan)->get();
        foreach ($records as $record) {
            try {
                NoaaPrediction::find($record->id)->delete();
            } catch(Exception $e) {
                continue;
            }
        }

        return true;
    }

    private function deleteWeatherForecastRecords(\Carbon\Carbon $olderThan, $bar)
    {
        $bar->advance();
        $this->info("\nDeleting weather_forecasts records older than $olderThan");

        $records = WeatherForecast::where('timestamp', '<', $olderThan)->get();
        foreach ($records as $record) {
            try {
                WeatherForecast::find($record->id)->delete();
            } catch(Exception $e) {
                continue;
            }
        }

        return true;
    }

    private function deleteWeatherDataRecords(\Carbon\Carbon $olderThan, $bar)
    {
        $bar->advance();
        $this->info("\nDeleting weather_data records older than $olderThan");

        $records = WeatherData::where('timestamp', '<', $olderThan)->get();
        foreach ($records as $record) {
            try {
                WeatherData::find($record->id)->delete();
            } catch(Exception $e) {
                continue;
            }
        }

        return true;
    }
}
