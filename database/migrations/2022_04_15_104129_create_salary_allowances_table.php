<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_salary_allowance', function (Blueprint $table) {
            $table->id('salary_allowance_id');
            //$table->primary('salary_allowance_id');
            $table->integer('salary_template_id');
            $table->string('allowance_label');
            $table->integer('allowance_value');
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
        Schema::dropIfExists('tbl_salary_allowance');
    }
}
