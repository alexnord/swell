<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Buoy;
use App\BuoyData;

class GetNdbcData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:ndbc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape NDBC buoy data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function celToFah(float $degrees)
    {
        return $degrees * 1.8 + 32;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $buoys = Buoy::where('active', true)->get();
        
        foreach ($buoys as $buoy) {
            $this->info("Scraping data for {$buoy->title}.");

            $url = config('apis.ndbc') . '/' . $buoy->station_id . '.txt' ;

            try {
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $url, []);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
                return;
            }

            $contents = $res->getBody()->getContents();
            $rows = explode("\n", $contents);

            $bar = $this->output->createProgressBar(count($rows));

            $updatedCount = 0;
            foreach ($rows as $key => $row) {
                preg_match("/(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*(\d+)\s*MM\s*MM\s*MM\s*(\d+.\d+)\s*(\d+)\s*(\d+.\d+)\s*(\d+.\d+)\s*MM\s*MM\s*(\d+\d+.\d+)/", $row, $parsed);
                
                try {
                    $dt = $parsed[1].'-'.$parsed[2].'-'.$parsed[3].' '.$parsed[4].':'.$parsed[5].':00';
                } catch(\Exception $e) {
                    continue;
                }
                
                $timestamp = Carbon::parse($dt);
                $waveHeight = $parsed[6] * 3.28084; // Convert m to ft
                $dPeriod = $parsed[7];
                $aPeriod = $parsed[8];
                $angle = $parsed[9];
                $wTemp = $this->celToFah($parsed[10]);

                // Skip duplicates
                if (!$exists = BuoyData::where('timestamp', $timestamp)->where('buoy_id', $buoy->id)->first()) {
                    $record = BuoyData::create([
                        'timestamp' => $timestamp,
                        'buoy_id' => $buoy->id,
                        'wave_height' => $waveHeight,
                        'dominant_period' => $dPeriod,
                        'average_period' => $aPeriod,
                        'angle' => $angle,
                        'water_temp' => $wTemp,
                    ]);
                    $updatedCount++;
                }

                $bar->advance();

            }
            $this->info("\n{$updatedCount} records updated for {$buoy->title}");   
        }
        
        $this->info("\nFinished scraping all buoy data.");
        return;
    }
}
