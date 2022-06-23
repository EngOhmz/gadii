<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_salary_payments', function (Blueprint $table) {
            $table->id('salary_payment_id');
            $table->integer('user_id');
            $table->integer('payment_month');
            $table->integer('fine_deduction')->nullable();
            $table->integer('payment_type');
            $table->integer('comments');
            $table->date('payed_date');
            $table->integer('deduct_from');
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
        Schema::dropIfExists('tbl_salary_payments');
    }
}
