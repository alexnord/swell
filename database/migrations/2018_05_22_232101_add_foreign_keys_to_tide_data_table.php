<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToTideDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tide_data', function (Blueprint $table) {
            $table->foreign('noaa_station_id', 'tide_data_noaa_station_ibfk_1')->references('id')->on('noaa_stations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tide_data', function (Blueprint $table) {
            $table->dropForeign('tide_data_noaa_station_ibfk_1');
        });
    }
}
