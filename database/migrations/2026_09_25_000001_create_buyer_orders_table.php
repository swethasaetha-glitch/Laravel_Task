<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buyer_orders', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name');
            $table->string('po_number')->unique();
            $table->date('order_date');
            $table->date('delivery_date');
            $table->integer('total_garment_qty');
            $table->string('status')->default('Confirmed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buyer_orders');
    }
};
