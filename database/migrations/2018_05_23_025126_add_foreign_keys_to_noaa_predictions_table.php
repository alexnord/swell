<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToNoaaPredictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('noaa_predictions', function (Blueprint $table) {
            $table->foreign('noaa_station_id', 'noaa_predictions_ibfk_1')->references('id')->on('noaa_stations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('noaa_predictions', function (Blueprint $table) {
            $table->dropForeign('noaa_predictions_ibfk_1');
        });
    }
}
