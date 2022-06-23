<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTyreReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_returns', function (Blueprint $table) {
            $table->id();
            $table->string('tyre_id');  
            $table->string('truck_id');  
            $table->string('location');  
            $table->string('staff');
            $table->date('date');
            $table->integer('status');               
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
        Schema::dropIfExists('tyre_returns');
    }
}
