<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIrrigationProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_irrigation_processes', function (Blueprint $table) {
            $table->id();
            $table->date('irrigation_date');
            $table->integer('water_volume');
            $table->date('next_date');
            $table->integer('cost_per_heck');
            $table->integer('no_of_heck');
            $table->integer('total_volume');
            $table->integer('added_by');
            $table->integer('seasson_id');
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
        Schema::dropIfExists('tbl_irrigation_processes');
    }
}
