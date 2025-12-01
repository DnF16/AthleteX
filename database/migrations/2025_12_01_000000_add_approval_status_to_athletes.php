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
        Schema::table('athletes', function (Blueprint $table) {
            // Add approval_status column: pending, approved, declined
            $table->string('approval_status')->default('pending')->after('coach_id');
            $table->text('approval_notes')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('approval_notes');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'approval_notes', 'approved_at', 'approved_by']);
        });
    }
};
