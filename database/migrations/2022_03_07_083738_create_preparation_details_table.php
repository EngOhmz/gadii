<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreparationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_preparation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('seasson_id');
            $table->integer('organization_id');
            $table->string('preparation_type');
            $table->string('soil_salt');
            $table->string('moisture_level');
            $table->string('preparation_cost');
            $table->integer('status');
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
        Schema::dropIfExists('tbl_preparation_details');
    }
}
