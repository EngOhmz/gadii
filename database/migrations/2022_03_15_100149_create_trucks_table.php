<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('truck_name');
            $table->string('reg_no');
            $table->string('driver');
            $table->string('truck_type');           
            $table->string('capacity');
            $table->string('fuel')->nullable();
            $table->string('truck_status');
            $table->string('driver_status');
            $table->string('tyre')->nullable();
            $table->string('staff')->nullable();           
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
        Schema::dropIfExists('trucks');
    }
}
