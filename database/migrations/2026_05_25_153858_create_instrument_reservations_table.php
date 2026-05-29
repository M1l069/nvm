<?php

use App\Enums\InstrumentReservationStatus;
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
        Schema::create('instrument_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reserved_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reserved_for')->constrained('users')->cascadeOnDelete();
            $table->dateTime('from');
            $table->dateTime('to');
            $table->text('description')->nullable();
            $table->string('status')->default(InstrumentReservationStatus::Reserved);
            $table->index(['instrument_id', 'from', 'to']);
            $table->timestamps();
        });
    }

    //reserved
    //cancelled
    //completed

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrument_reservations');
    }
};
