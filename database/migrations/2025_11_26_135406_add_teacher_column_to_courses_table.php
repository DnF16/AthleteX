<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('courses', function (Blueprint $table) {
        // Add the missing 'teacher' column
        $table->string('teacher')->nullable()->after('subject'); 
    });
}

public function down()
{
    Schema::table('courses', function (Blueprint $table) {
        // Drop the column if the migration is rolled back
        $table->dropColumn('teacher');
    });
}
};
