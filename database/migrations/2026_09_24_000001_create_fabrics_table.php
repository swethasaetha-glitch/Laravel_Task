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
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->string('fabric_code')->unique();
            $table->string('fabric_name');
            $table->string('fabric_type');
            $table->string('composition')->nullable();
            $table->string('color')->nullable();
            $table->decimal('gsm', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->string('unit')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
