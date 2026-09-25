<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_pos', function (Blueprint $table) {
            $table->id();
            $table->string('po_no')->unique();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->onDelete('cascade');
            $table->foreignId('fabric_id')->constrained('fabrics')->onDelete('cascade');
            $table->string('supplier_name');
            $table->decimal('required_qty', 10, 2);
            $table->string('unit')->default('KG');
            $table->date('delivery_date');
            $table->string('status')->default('Ordered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_pos');
    }
};
