<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert default sports events
        DB::table('sports')->insert([
            ['name' => 'Athletic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Archery', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Badminton', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baseball', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Basketball', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chess', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Football', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Judo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lawn Tennis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sepak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Softball', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Table Tennis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Taekwondo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Volleyball', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wushu Sanda', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wushu Taolu', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};