<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierReferenceNoToRestaurantPosPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_pos_purchases', function (Blueprint $table) {
            $table->string('supplier_reference_no')->nullable()->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_pos_purchases', function (Blueprint $table) {
            $table->dropColumn('supplier_reference_no');
        });
    }
}
