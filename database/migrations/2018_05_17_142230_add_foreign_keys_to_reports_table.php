<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('user_id', 'report_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('location_id', 'report_ibfk_2')->references('id')->on('locations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('swell_dir_id', 'report_ibfk_3')->references('id')->on('directions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('wind_dir_id', 'report_ibfk_4')->references('id')->on('directions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tide_dir_id', 'report_ibfk_5')->references('id')->on('tides')->onUpdate('
                CASCADE')->onDelete('CASCADE');
            $table->foreign('condition_id', 'report_ibfk_6')->references('id')->on('conditions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign('report_ibfk_1');
            $table->dropForeign('report_ibfk_2');
            $table->dropForeign('report_ibfk_3');
            $table->dropForeign('report_ibfk_4');
            $table->dropForeign('report_ibfk_5');
            $table->dropForeign('report_ibfk_6');
        });
    }
}
