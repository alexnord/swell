<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToWeatherDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->foreign('location_id', 'wd_location_id_ibfk_1')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->dropForeign('wd_location_id_ibfk_1');
        });
    }
}
