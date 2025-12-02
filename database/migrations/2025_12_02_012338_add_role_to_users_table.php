<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In add_role_to_users_table.php
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the 'role' column with a default of 'coach' or 'user'
             
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
