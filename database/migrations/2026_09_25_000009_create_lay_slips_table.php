<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lay_slips', function (Blueprint $table) {
            $table->id();
            $table->string('lay_slip_no')->unique();
            $table->foreignId('production_plan_id')->constrained('production_plans')->onDelete('cascade');
            $table->foreignId('lay_model_id')->constrained('lay_models')->onDelete('cascade');
            $table->foreignId('fabric_group_id')->constrained('fabric_groups')->onDelete('cascade');
            $table->string('table_no');
            $table->string('spreader_operator');
            $table->integer('total_plies');
            $table->decimal('lay_length', 8, 2);
            $table->decimal('marker_efficiency_pct', 5, 2)->default(85.50);
            $table->string('status')->default('Lay Completed'); // Planned, In Spreading, Lay Completed
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lay_slips');
    }
};
