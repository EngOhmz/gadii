<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('pos_invoices', 'profoma_attachment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->string('profoma_attachment')->nullable()->after('delivery_terms');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pos_invoices', 'profoma_attachment')) {
            Schema::table('pos_invoices', function (Blueprint $table) {
                $table->dropColumn('profoma_attachment');
            });
        }
    }
};


