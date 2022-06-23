<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->integer('supplier_id');
            $table->date('purchase_date');
            $table->date('due_date');
            $table->integer('user_id');
            $table->integer('exchange_rate');
            $table->integer('purchase_amount');
            $table->integer('due_amount');
            $table->integer('purchase_tax');
            $table->integer('status');
            $table->integer('total');
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
        Schema::dropIfExists('tbl_purchases');
    }
}
