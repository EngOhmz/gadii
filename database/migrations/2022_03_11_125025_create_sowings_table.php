<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sowings', function (Blueprint $table) {
            $table->id();
            $table->integer('seasson_id');
            $table->integer('crop_type');
            $table->integer('seed_type');
            $table->integer('user_id');
        
            $table->date('harvest_date');
            $table->integer('gheck');
            $table->integer('cost');
            $table->integer('nh');
            $table->integer('qn');
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
        Schema::dropIfExists('tbl_sowings');
    }
}
