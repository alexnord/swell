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
            $table->integer('user_id')->unsigned()->index('r_user_id');
            $table->date('date');

            $table->time('start_time');
            $table->time('end_time')->nullable();

            $table->integer('location_id')->unsigned()->index('r_location_id');
            
            $table->string('start_swell_dir');
            $table->float('start_swell_angle', 4, 1);
            $table->float('start_swell_height', 3, 1);
            $table->float('start_swell_period', 3, 1);

            $table->string('end_swell_dir')->nullable();
            $table->float('end_swell_angle', 4, 1)->nullable();
            $table->float('end_swell_height', 3, 1)->nullable();
            $table->float('end_swell_period', 3, 1)->nullable();

            $table->string('start_wind_dir');
            $table->float('start_wind_speed', 3, 1);

            $table->string('end_wind_dir')->nullable();
            $table->float('end_wind_speed', 3, 1)->nullable();

            $table->string('tide_dir');
            $table->float('start_tide_height', 3, 1);
            $table->float('end_tide_height', 3, 1)->nullable();

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
