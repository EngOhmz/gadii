<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTyreBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_brands', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer');
            $table->string('brand');
            $table->string('size');  
            $table->decimal('price');  
            $table->decimal('quantity');   
            $table->string('unit');                 
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
        Schema::dropIfExists('tyre_brands');
    }
}
