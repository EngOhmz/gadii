<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transport_quotations', function (Blueprint $table) {
            $table->id();
            $table->date('crop_type');
            $table->integer('quantity');
            $table->integer('from');
            $table->integer('to');
            $table->integer('client_id');
            $table->integer('warehouse_id');
            $table->integer('amount');
            $table->integer('status');
            $table->integer('user_id');
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
        Schema::dropIfExists('tbl_transport_quotations');
    }
}
