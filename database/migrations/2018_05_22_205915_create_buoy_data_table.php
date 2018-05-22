<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuoyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buoy_data', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('timestamp')->nullable();
            $table->integer('buoy_id')->unsigned()->index('b_buoy_id');
            $table->float('wave_height', 4, 2);
            $table->integer('dominant_period');
            $table->float('average_period', 4, 2);
            $table->integer('angle');
            $table->float('water_temp', 4, 2);
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
        Schema::dropIfExists('buoy_data');
    }
}
