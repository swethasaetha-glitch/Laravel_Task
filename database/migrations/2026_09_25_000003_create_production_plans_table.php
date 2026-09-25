<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_no')->unique();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->onDelete('cascade');
            $table->date('planned_start_date');
            $table->date('planned_end_date');
            $table->integer('target_daily_qty');
            $table->string('line_allocation')->nullable();
            $table->string('status')->default('Approved');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_plans');
    }
};
