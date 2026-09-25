<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_no')->unique();
            $table->foreignId('fabric_roll_id')->constrained('fabric_rolls')->onDelete('cascade');
            $table->decimal('inspected_length', 8, 2);
            $table->integer('total_penalty_points')->default(0);
            $table->decimal('points_per_100_sq_yds', 8, 2)->default(0);
            $table->string('grade')->default('A'); // Grade A, B, C
            $table->string('inspector_name');
            $table->string('status')->default('Passed'); // Passed, Rejected, Rework
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_inspections');
    }
};
