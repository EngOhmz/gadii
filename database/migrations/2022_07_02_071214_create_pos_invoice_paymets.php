<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosInvoicePaymets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_invoice_payments', function (Blueprint $table) {
            $table->id();           
            $table->string('invoice_id');
            $table->string('trans_id');
            $table->decimal('amount');
            $table->date('date');
            $table->string('payment_method');
            $table->string('notes')->nullable();               
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
        Schema::dropIfExists('pos_invoice_payments');
    }
}
