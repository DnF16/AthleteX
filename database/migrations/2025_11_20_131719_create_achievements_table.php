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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id');     // link to athlete

            $table->string('year');
            $table->string('month_day');
            $table->string('event');
            $table->string('venue');  
            $table->string('award');
            $table->string('category')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('athlete_id')
                ->references('id')
                ->on('athletes')
                ->onDelete('cascade');
        });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
