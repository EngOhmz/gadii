<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePestisidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pestisides', function (Blueprint $table) {
            $table->id();
            $table->string('pestiside_type');
            $table->integer('farming_process');
            $table->integer('pestiside_amount');
            $table->integer('total_amount');
            $table->integer('pestiside_price');
            $table->integer('pestiside_cost');
            $table->integer('no_hector');
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
        Schema::dropIfExists('tbl_pestisides');
    }
}
