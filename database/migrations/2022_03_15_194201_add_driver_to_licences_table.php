<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverToLicencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licences', function (Blueprint $table) {
            $table->after('attachment',function (Blueprint $table){
                $table->string('driver_id');
        });
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licences', function (Blueprint $table) {
            //
            $table->dropColumn('driver_id');
        });
    }
}
