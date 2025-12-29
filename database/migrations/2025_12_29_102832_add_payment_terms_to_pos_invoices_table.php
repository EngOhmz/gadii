<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTermsToPosInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pos_invoices', 'payment_days')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->integer('payment_days')->nullable()->after('due_date');
            });
        }
        
        if (!Schema::hasColumn('pos_invoices', 'is_due_for_payment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->boolean('is_due_for_payment')->default(0)->after('payment_days');
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
        if (Schema::hasColumn('pos_invoices', 'payment_days')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->dropColumn('payment_days');
            });
        }
        
        if (Schema::hasColumn('pos_invoices', 'is_due_for_payment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->dropColumn('is_due_for_payment');
            });
        }
    }
}
