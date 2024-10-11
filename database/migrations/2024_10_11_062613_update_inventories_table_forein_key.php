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
        Schema::table('inventories', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['consignment_id']);

            $table->foreign('consignment_id')
                ->references('id')->on('consignments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['consignment_id']);

            // Add the foreign key back without ON DELETE CASCADE
            $table->foreign('consignment_id')->references('id')->on('consignments');
        });
    }
};
