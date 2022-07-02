<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('unit');
            $table->integer('tax');
            $table->string('description')->nullavle();
            $table->string('status')->nullable();
            $table->string('added_by');
         
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
        Schema::dropIfExists('tbl_items');
    }
}
