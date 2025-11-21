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
        Schema::create('fees_discounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('athlete_id');

            $table->string('academic_year')->nullable();
            $table->string('term')->nullable();
            $table->string('fee_type')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('remarks')->nullable();

            $table->timestamps();

            $table->foreign('athlete_id')
                ->references('id')->on('athletes')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_discounts');
    }
};
