<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_purchase_items', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_id');
            $table->string('item_name');
            $table->integer('purchase_tax');
            $table->integer('purchase_amount');
            $table->integer('reference_no');
            $table->integer('due_amount');
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
        Schema::dropIfExists('pos_purchase_items');
    }
}
