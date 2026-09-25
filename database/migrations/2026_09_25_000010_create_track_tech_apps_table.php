<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('track_tech_apps', function (Blueprint $table) {
            $table->id();
            $table->integer('sno');
            $table->string('app_name');
            $table->string('package_name');
            $table->string('live_version');
            $table->string('test_version');
            $table->string('category')->default('Production Module');
            $table->string('route_name')->nullable();
            $table->string('status')->default('ONLINE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('track_tech_apps');
    }
};
