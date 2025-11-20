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
        Schema::create('sample_tubes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_collection_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('tube_type');
            $table->string('barcode')->unique();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_tubes');
    }
};
