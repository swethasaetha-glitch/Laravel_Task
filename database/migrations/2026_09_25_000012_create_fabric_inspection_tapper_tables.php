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
        Schema::create('tapper_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tapper_no')->unique();
            $table->foreignId('fabric_id')->constrained('fabrics')->cascadeOnDelete();
            $table->string('roll_no');
            $table->decimal('before_shrinkage_len', 8, 2)->default(0.00);
            $table->decimal('before_shrinkage_width', 8, 2)->default(0.00);
            $table->decimal('after_shrinkage_len', 8, 2)->default(0.00);
            $table->decimal('after_shrinkage_width', 8, 2)->default(0.00);
            $table->decimal('shrinkage_percent', 5, 2)->default(0.00);
            $table->string('shade_group');
            $table->string('arvind_approval_status')->default('Approved'); // Approved, Pending, Rejected
            $table->decimal('allowance_value', 5, 2)->default(0.70); // 0.70 / 0.60 allowance
            $table->text('quality_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('fabric_roll_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_no')->unique();
            $table->foreignId('fabric_roll_id')->constrained('fabric_rolls')->cascadeOnDelete();
            $table->string('requested_by_dept')->default('Cutting');
            $table->enum('status', ['requested', 'reserved', 'unreserved', 'issued', 'returned'])->default('requested');
            $table->string('storage_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabric_roll_reservations');
        Schema::dropIfExists('tapper_reports');
    }
};
