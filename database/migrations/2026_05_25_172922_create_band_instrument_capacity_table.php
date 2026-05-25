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
        Schema::create('band_instrument_capacity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('band_id')->constrained('bands')->cascadeOnDelete();
            $table->foreignId('specialization_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('band_instrument_capacity');
    }
};
