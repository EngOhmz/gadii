<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->string('truck_id');
            $table->string('route_id');
            $table->decimal('fuel_rate');
            $table->decimal('fuel_used');
            $table->decimal('due_fuel');
            $table->decimal('fuel_adjustment')->nullable();
            $table->text('reason')->nullable();
            $table->string('status_approve')->nullable();               
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
        Schema::dropIfExists('fuels');
    }
}
