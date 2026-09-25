<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fabric_relaxations', function (Blueprint $table) {
            $table->id();
            $table->string('relaxation_no')->unique();
            $table->foreignId('fabric_roll_id')->constrained('fabric_rolls')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('required_hours')->default(24);
            $table->decimal('shrinkage_pct', 5, 2)->default(0);
            $table->string('status')->default('Relaxing'); // Relaxing, Completed, Ready for Lay
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fabric_relaxations');
    }
};
