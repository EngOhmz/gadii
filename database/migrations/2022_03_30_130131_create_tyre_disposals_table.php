<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTyreDisposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_disposals', function (Blueprint $table) {
            $table->id();
            $table->string('tyre_id');
            $table->date('date');
            $table->string('staff');           
            $table->decimal('quantity')->nullable(); 
            $table->string('location');
            $table->string('status');
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
        Schema::dropIfExists('tyre_disposals');
    }
}
