<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFertilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_fertilizers', function (Blueprint $table) {
            $table->id();
            $table->string('package');
            $table->integer('farming_process');
            $table->integer('fertilizer_amount');
            $table->integer('total_amount');
            $table->integer('fertilizer_price');
            $table->integer('fertilizer_cost');
            $table->integer('no_hector');
            $table->integer('seasson_id');
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
        Schema::dropIfExists('tbl_fertilizers');
    }
}
