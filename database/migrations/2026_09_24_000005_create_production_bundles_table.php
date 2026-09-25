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
        Schema::create('production_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no')->unique();
            $table->string('buyer');
            $table->string('style_no');
            $table->string('order_no');
            $table->string('garment');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->integer('total_qty')->default(0);
            $table->integer('completed_qty')->default(0);
            $table->integer('rejected_qty')->default(0);
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_bundles');
    }
};
