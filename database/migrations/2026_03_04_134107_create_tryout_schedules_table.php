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
            $table->string('sport_event')->nullable();
            $table->date('tryout_date')->nullable();
            $table->time('tryout_time')->nullable();
            $table->string('venue')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_schedules');
    }
};