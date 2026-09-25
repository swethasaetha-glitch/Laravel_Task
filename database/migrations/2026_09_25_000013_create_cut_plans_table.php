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
        Schema::create('cut_plans', function (Blueprint $table) {
            $table->id();
            $table->string('cut_plan_no')->unique();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnDelete();
            $table->foreignId('fabric_id')->constrained('fabrics')->cascadeOnDelete();
            $table->string('cad_type')->default('Marker'); // Marker, Pattern
            $table->string('unit_of_measure')->default('Metres'); // Metres for Shirts/Denim, Kg for Knits
            
            // Cut Plan Settings
            $table->integer('no_of_piles')->default(100);
            $table->json('size_breakup')->nullable(); // e.g. {"S": 10, "M": 20, "L": 20, "XL": 10}
            $table->integer('order_qty')->default(0);
            $table->integer('extra_qty')->default(0);

            // Cut Plan Types
            $table->enum('cut_plan_type', [
                'step_down',
                'mini_marker',
                'selected_size',
                'selected_ratio',
                'piles_multiples',
                'partial_cut'
            ])->default('selected_ratio');

            // Fabric Group Allocation
            $table->enum('group_allocation', [
                'automatic',
                'factory_cut_plan',
                'fit_mode',
                'max_pcs',
                'piles_adjust',
                'equal_size',
                'auto_endbit'
            ])->default('automatic');

            $table->enum('status', ['draft', 'planned', 'lay_assigned', 'in_cutting', 'completed'])->default('planned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_plans');
    }
};
