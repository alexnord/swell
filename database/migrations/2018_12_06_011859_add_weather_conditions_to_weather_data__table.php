<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeatherConditionsToWeatherDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->string('temp')->after('speed')->nullable();
            $table->string('text')->after('temp')->nullable();
            $table->string('sunrise')->after('text')->nullable();
            $table->string('sunset')->after('sunrise')->nullable();
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
            $table->dropColumn('temp');
            $table->dropColumn('text');
            $table->dropColumn('sunrise');
            $table->dropColumn('sunset');
        });
    }
}
