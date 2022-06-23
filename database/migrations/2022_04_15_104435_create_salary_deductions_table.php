<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_salary_deduction', function (Blueprint $table) {
            $table->id('salary_deduction_id');
            //$table->primary('salary_deduction_id');
            $table->integer('salary_template_id');
            $table->string('deduction_label');
            $table->integer('deduction_value');
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
        Schema::dropIfExists('tbl_salary_deduction');
    }
}
