<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrrigationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_irrigation_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('irrigation_type');
            $table->integer('irrigation_cost');
            $table->integer('number_of_hk');
            $table->string('power_source');
            $table->integer('pump_cost');
            $table->integer('pump_rate');
            $table->integer('hector_per_day');
            $table->integer('pump_no');
            $table->integer('total_pump_cost');
            $table->integer('added_by');
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
        Schema::dropIfExists('tbl_irrigation_settings');
    }
}
