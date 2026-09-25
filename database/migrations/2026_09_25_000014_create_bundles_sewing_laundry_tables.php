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
        Schema::create('lot_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no')->unique();
            $table->string('qr_code_hash')->unique();
            $table->foreignId('cut_plan_id')->nullable()->constrained('cut_plans')->nullOnDelete();
            $table->foreignId('lay_slip_id')->nullable()->constrained('lay_slips')->nullOnDelete();
            $table->foreignId('style_id')->nullable()->constrained('styles')->nullOnDelete();
            $table->string('size');
            $table->string('shade_group')->default('Shade A');
            $table->integer('garment_qty')->default(20);
            $table->foreignId('operator_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('supervisors')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->enum('stage', [
                'cutting_completed',
                'numbering_done',
                'supermarket',
                'sewing_issued',
                'sew_in',
                'mid_line',
                'sew_out',
                'washing_laundry',
                'finishing',
                'completed'
            ])->default('numbering_done');
            $table->timestamps();
        });

        Schema::create('sewing_machine_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_bundle_id')->constrained('lot_bundles')->cascadeOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->string('department')->default('Sewing');
            $table->enum('scan_type', ['in_scan', 'mid_scan', 'out_scan']);
            $table->timestamp('scanned_at');
            $table->timestamps();
        });

        Schema::create('laundry_records', function (Blueprint $table) {
            $table->id();
            $table->string('wash_batch_no')->unique();
            $table->foreignId('lot_bundle_id')->constrained('lot_bundles')->cascadeOnDelete();
            $table->string('wash_type')->default('Normal Wash'); // Normal Wash, Enzyme Wash, Stone Wash, Bleach
            $table->enum('status', ['received', 'in_washing', 'drying', 'passed', 'rejected'])->default('received');
            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('quality_dashboard_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_bundle_id')->constrained('lot_bundles')->cascadeOnDelete();
            $table->foreignId('garment_defect_id')->nullable()->constrained('garment_defects')->nullOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->string('department')->default('Sewing');
            $table->integer('defect_count')->default(1);
            $table->enum('audit_result', ['pass', 'rework', 'reject'])->default('pass');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_dashboard_audits');
        Schema::dropIfExists('laundry_records');
        Schema::dropIfExists('sewing_machine_scans');
        Schema::dropIfExists('lot_bundles');
    }
};
