<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintainances', function (Blueprint $table) {
            $table->id();
            $table->string('truck');
            $table->string('truck_name');
            $table->string('driver');
            $table->string('mechanical');
            $table->date('date');
            $table->string('type');
            $table->text('reason')->nullable();   
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
        Schema::dropIfExists('maintainances');
    }
}
