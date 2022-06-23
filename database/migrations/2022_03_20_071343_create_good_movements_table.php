<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_movements', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->date('date');
            $table->string('staff');   
            $table->string('source_location');  
            $table->string('destination_location');            
            $table->decimal('quantity'); 
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
        Schema::dropIfExists('good_movements');
    }
}
