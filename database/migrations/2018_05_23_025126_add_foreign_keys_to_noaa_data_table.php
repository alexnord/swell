<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToNoaaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noaa_data', function (Blueprint $table) {
            $table->foreign('noaa_station_id', 'noaa_data_ibfk_1')->references('id')->on('noaa_stations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('noaa_data', function (Blueprint $table) {
            $table->dropForeign('noaa_data_ibfk_1');
        });
    }
}
