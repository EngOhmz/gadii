<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacel_items', function (Blueprint $table) {
            $table->id();
            $table->string('pacel_id');
            $table->string('item_name');
            $table->decimal('tax_rate');
            $table->decimal('total_tax');
            $table->decimal('quantity');
            $table->decimal('total_cost');
            $table->decimal('price');
            $table->string('unit');        
            $table->integer('items_id');           
            $table->integer('order_no');         
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
        Schema::dropIfExists('pacel_items');
    }
}
