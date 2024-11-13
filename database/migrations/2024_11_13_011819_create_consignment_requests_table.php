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
        Schema::create('consignment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consignor_id');
            $table->string('name');
            $table->string('brand');
            $table->string('sku')->unique();
            $table->string('colorway');
            $table->string('size');
            $table->text('description')->nullable();
            $table->enum('sex', ['Male', 'Female', 'Unisex'])->nullable();
            $table->integer('quantity');
            $table->enum('condition', ['Brand new', 'Used', 'Slightly used']);
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('consignor_commission', 5, 2);
            $table->date('pullout_date')->nullable();
            $table->string('image')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_requests');
    }
};
