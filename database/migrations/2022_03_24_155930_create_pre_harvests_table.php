<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreHarvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pre_harvests', function (Blueprint $table) {
            $table->id();
            $table->string('maturity_index');
            $table->string('crop_type');
            $table->integer('non_rain_day');
            $table->integer('moisture_level');
            $table->string('harvest_method');
            $table->integer('seasson_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('tbl_pre_harvests');
    }
}
