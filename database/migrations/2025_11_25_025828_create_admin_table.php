<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Settings (General Info, App Config, Scheduling Defaults)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 2. Classes / Courses
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('location')->nullable();
            $table->string('teacher')->nullable();
            $table->string('subject');
            $table->string('type'); 
            $table->string('status')->default('Active');
            $table->string('icon_file')->nullable();
            $table->timestamps();
        });

        // 3. Transaction Items
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); 
            $table->string('category');
            $table->timestamps();
        });

        // 4. Holidays (Scheduling)
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('term')->nullable();
            $table->timestamps();
        });

        // 5. Certificates (Awards & Templates)
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); 
            $table->string('filename');
            $table->timestamps();
        });
        
        // 6. Update Users Table for Permissions
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->json('permissions')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('certificates');
        // Drop other tables if needed
    }
};