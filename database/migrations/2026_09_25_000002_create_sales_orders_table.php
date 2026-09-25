<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sales_order_no')->unique();
            $table->foreignId('buyer_order_id')->constrained('buyer_orders')->onDelete('cascade');
            $table->string('style_no');
            $table->string('garment_type');
            $table->string('colorway');
            $table->string('size_ratio')->nullable(); // e.g. S:1, M:2, L:2, XL:1
            $table->integer('order_qty');
            $table->string('status')->default('In Production');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
