<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyWeatherForecastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_weather_forecast', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('timestamp')->nullable();
            $table->integer('location_id')->unsigned()->index('wf_location_id');
            $table->string('text');
            $table->string('icon');
            $table->string('temperature_high');
            $table->string('temperature_low');
            $table->string('sunrise');
            $table->string('sunset');
            $table->string('angle');
            $table->float('speed', 4, 2);
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
        Schema::dropIfExists('daily_weather_forecast');
    }
}
