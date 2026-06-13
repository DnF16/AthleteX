<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_schedules', function (Blueprint $table) {
            $table->id();
            // Assuming it links to your athletes table
            $table->foreignId('athlete_id')->constrained()->cascadeOnDelete();
            $table->string('sport_event')->nullable();
            $table->dateTime('tryout_date')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_schedules');
    }
};