<?php

use App\Enums\LessonState;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_school_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('time_slot_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->string('state')->default(LessonState::Planned->value);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['subject_school_year_id', 'date']);
            $table->index(['room_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
