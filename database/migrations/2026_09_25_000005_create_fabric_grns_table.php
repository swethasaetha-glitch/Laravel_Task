<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_grns', function (Blueprint $table) {
            $table->id();
            $table->string('grn_no')->unique();
            $table->foreignId('fabric_po_id')->constrained('fabric_pos')->onDelete('cascade');
            $table->string('supplier_invoice_no');
            $table->date('received_date');
            $table->integer('total_rolls_received');
            $table->decimal('received_qty', 10, 2);
            $table->string('status')->default('Received');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_grns');
    }
};
