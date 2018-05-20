<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoaaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noaa_data', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('timestamp')->nullable()->unique();
            $table->float('swell_direction', 5, 2);
            $table->float('swell_height', 4, 2);
            $table->float('swell_period', 4, 2);
            $table->float('wave_direction', 5, 2);
            $table->float('wave_height', 4, 2);
            $table->float('wave_period', 4, 2)->nullable();
            $table->float('wind_direction', 5, 2)->nullable();
            $table->float('wind_speed', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noaa_data');
    }
}