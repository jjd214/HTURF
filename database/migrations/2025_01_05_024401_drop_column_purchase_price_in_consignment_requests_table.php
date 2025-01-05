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
        Schema::table('consignment_requests', function (Blueprint $table) {
            //
            $table->dropColumn(['purchase_price']);
            $table->string('payout_price')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consignment_requests', function (Blueprint $table) {
            //
            $table->string('purchase_price')->after('status');
            $table->dropColumn(['payout_price']);
        });
    }
};
