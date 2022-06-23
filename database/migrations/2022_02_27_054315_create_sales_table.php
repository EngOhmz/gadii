<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sales', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->integer('client_id');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->integer('user_id');
            $table->integer('exchange_rate');
            $table->integer('currency_code');
            $table->integer('invoice_amount');
            $table->integer('due_amount');
            $table->integer('invoice_tax');
            $table->integer('status');
            
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
        Schema::dropIfExists('tbl_sales');
    }
}
