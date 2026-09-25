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
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->string('style_no')->unique();
            $table->string('style_name');
            $table->foreignId('buyer_order_id')->nullable()->constrained('buyer_orders')->nullOnDelete();
            $table->string('garment_type')->default('Shirts'); // Shirts, Denim, Knits, etc.
            $table->decimal('sam', 8, 2)->default(0.00); // Standard Allowed Minutes
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('process_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('style_id')->constrained('styles')->cascadeOnDelete();
            $table->integer('sequence_order')->default(1);
            $table->string('process_name'); // e.g. Fabric Store, Laying, Cutting, Numbering, Sewing In, Mid Line QC, Sewing Out, Washing, Finishing
            $table->string('department'); // Fabric, CAD, Cutting, Sewing, Washing, Quality, Finishing
            $table->decimal('sam', 8, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('machine_no')->unique();
            $table->string('machine_name');
            $table->string('machine_type'); // e.g., Straight Knife, Band Knife, Single Needle, Overlock, Washing Drum
            $table->string('department'); // Cutting, Sewing, Washing, Finishing
            $table->string('line_no')->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('operator_code')->unique();
            $table->string('name');
            $table->string('department');
            $table->string('skill_level')->default('Grade A'); // Grade A, B, C
            $table->string('line_no')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->string('supervisor_code')->unique();
            $table->string('name');
            $table->string('department');
            $table->string('shift')->default('Day');
            $table->timestamps();
        });

        Schema::create('garment_defects', function (Blueprint $table) {
            $table->id();
            $table->string('defect_code')->unique();
            $table->string('defect_name');
            $table->string('category'); // Fabric, Cutting, Sewing, Washing, Finishing
            $table->enum('severity', ['minor', 'major', 'critical'])->default('major');
            $table->timestamps();
        });

        Schema::create('shades', function (Blueprint $table) {
            $table->id();
            $table->string('shade_code')->unique();
            $table->string('shade_group'); // Group A, Group B, Shade 01, etc.
            $table->decimal('allowance_min', 5, 2)->default(0.60);
            $table->decimal('allowance_max', 5, 2)->default(0.70);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shades');
        Schema::dropIfExists('garment_defects');
        Schema::dropIfExists('supervisors');
        Schema::dropIfExists('operators');
        Schema::dropIfExists('machines');
        Schema::dropIfExists('process_sequences');
        Schema::dropIfExists('styles');
    }
};
