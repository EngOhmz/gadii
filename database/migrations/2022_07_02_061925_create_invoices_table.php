<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->string('client_id');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('location')->nullable();
            $table->string('exchange_code');
            $table->decimal('exchange_rate');
            $table->decimal('invoice_amount');
            $table->decimal('due_amount');
            $table->decimal('invoice_tax');
            $table->integer('status');
            $table->integer('invoice_status');
            $table->string('good_receive');
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
        Schema::dropIfExists('pos_invoices');
    }
}
