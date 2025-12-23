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
        if (Schema::hasTable('restaurant_pos_purchases')) {
            Schema::table('restaurant_pos_purchases', function (Blueprint $table) {
                if (!Schema::hasColumn('restaurant_pos_purchases', 'supplier_reference_no')) {
                    $table->string('supplier_reference_no')->nullable()->after('supplier_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('restaurant_pos_purchases')) {
            Schema::table('restaurant_pos_purchases', function (Blueprint $table) {
                if (Schema::hasColumn('restaurant_pos_purchases', 'supplier_reference_no')) {
                    $table->dropColumn('supplier_reference_no');
                }
            });
        }
    }
}
