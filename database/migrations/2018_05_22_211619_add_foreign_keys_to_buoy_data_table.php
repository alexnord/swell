<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToBuoyDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buoy_data', function (Blueprint $table) {
            $table->foreign('buoy_id', 'buoy_ibfk_1')->references('id')->on('buoys')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buoy_data', function (Blueprint $table) {
            $table->dropForeign('buoy_ibfk_1');
        });
    }
}
