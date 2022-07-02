<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('item_name');
            $table->integer('invoice_tax');
            $table->integer('invoice_amount');
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
        Schema::dropIfExists('pos_invoice_items');
    }
}
