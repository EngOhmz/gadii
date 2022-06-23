<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_insurances', function (Blueprint $table) {
            $table->id();
            $table->string('broker_name');
            $table->string('company');
            $table->date('expire_date');
            $table->string('cover');   
            $table->decimal('value');      
            $table->date('cover_date');
            $table->string('truck_id');
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
        Schema::dropIfExists('truck_insurances');
    }
}
