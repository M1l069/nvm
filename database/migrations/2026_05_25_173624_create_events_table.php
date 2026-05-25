<?php

use App\Enums\EventType;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();
            $table->string('name');
            $table->string('type')->default(EventType::Concert);
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete(); // len ak sa udalosť koná v škole
            $table->string('location')->nullable(); // len ak sa udalosť koná mimo školy
            $table->unsignedSmallInteger('capacity')->nullable(); // len pre udalosti mimo školy
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->softDeletes();
            $table->index(['starts_at', 'ends_at', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
