<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeassonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_seassons', function (Blueprint $table) {
            $table->id();
            $table->string('seasson_name');
            $table->date('start_date');
            $table->date('farm_id');
            $table->date('farmer_id');
            $table->date('harvest_date');
            $table->string('crop_name');
            $table->integer('user_id');
            $table->string('status');
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
        Schema::dropIfExists('seassons');
    }
}
