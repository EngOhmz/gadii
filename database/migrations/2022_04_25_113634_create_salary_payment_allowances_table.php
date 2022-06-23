<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPaymentAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_salary_payment_allowance', function (Blueprint $table) {
            $table->id('salary_payment_allowance_id');
            $table->integer('salary_payment_id');
            $table->string('salary_payment_allowance_label');
            $table->string('salary_payment_allowance_value');
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
        Schema::dropIfExists('tbl_salary_payment_allowance');
    }
}
