<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_advance_salary', function (Blueprint $table) {
            $table->id('advance_salary_id');
            $table->integer('user_id');
            $table->integer('advance_amount');
            $table->date('deduct_month');
            $table->string('reason');
            $table->date('request_date');
            $table->integer('status');
            $table->integer('approve_by');
            $table->integer('added_by')->nullable();
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
        Schema::dropIfExists('tbl_advance_salary');
    }
}
