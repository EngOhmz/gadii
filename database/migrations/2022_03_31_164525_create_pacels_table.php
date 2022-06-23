<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacels', function (Blueprint $table) {
            $table->id();
            $table->string('pacel_name');
            $table->string('pacel_number');
            $table->date('date');
            $table->string('owner_id');
            $table->string('confirmation_number')->nullable();
            $table->string('weight');
            $table->string('route_id');
            $table->string('receiver_name');
            $table->integer('docs')->nullable();
            $table->integer('non_docs')->nullable();
            $table->integer('bags')->nullable();
            $table->string('mobile')->nullable();
            $table->string('currency_code');
            $table->decimal('exchange_rate');
            $table->decimal('amount')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('due_amount')->nullable();
            $table->decimal('discount')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('pacels');
    }
}
