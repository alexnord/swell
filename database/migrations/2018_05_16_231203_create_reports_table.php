<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(1)->index('r_active');
            $table->date('date');
            $table->time('time');
            $table->integer('location_id')->unsigned()->index('r_location_id');
            $table->integer('swell_dir_id')->unsigned()->index('r_swell_dir_id');
            $table->string('swell_angle');
            $table->string('swell_height');
            $table->string('swell_period');
            $table->integer('wind_dir_id')->unsigned()->index('r_wind_dir_id');
            $table->decimal('wind_speed', 2, 2);
            $table->integer('tide_dir_id')->unsigned()->index('r_tide_dir_id');
            $table->decimal('tide_height', 2, 2);
            $table->string('actual_surf_height');
            $table->integer('condition_id')->unsigned()->index('r_condition_id');
            $table->integer('score');
            $table->text('notes', 65535)->nullable();
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
        Schema::dropIfExists('reports');
    }
}
