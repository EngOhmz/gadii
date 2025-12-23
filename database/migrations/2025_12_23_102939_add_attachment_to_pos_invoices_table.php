<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentToPosInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('pos_invoices', 'attachment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('delivery_terms');
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
        if (Schema::hasColumn('pos_invoices', 'attachment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }
    }
}
