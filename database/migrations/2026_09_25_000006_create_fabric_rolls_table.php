<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_rolls', function (Blueprint $table) {
            $table->id();
            $table->string('roll_no')->unique();
            $table->foreignId('fabric_grn_id')->constrained('fabric_grns')->onDelete('cascade');
            $table->foreignId('fabric_id')->constrained('fabrics')->onDelete('cascade');
            $table->decimal('gross_weight', 8, 2);
            $table->decimal('net_weight', 8, 2);
            $table->decimal('width', 8, 2)->nullable();
            $table->string('shade')->default('A');
            $table->string('bin_location')->nullable(); // Fabric Store Bin (e.g. BIN-A12)
            $table->string('inspection_status')->default('Pending'); // Pending, Inspected, Passed, Rejected
            $table->string('relaxation_status')->default('Pending'); // Pending, Relaxing, Relaxed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_rolls');
    }
};
