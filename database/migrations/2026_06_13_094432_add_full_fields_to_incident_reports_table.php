<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->string('incident_title')->after('coach_id')->nullable();
            $table->string('incident_type')->after('incident_title')->nullable();
            $table->string('incident_type_specify')->after('incident_type')->nullable(); // For Accidents/Others details
            $table->date('incident_date')->after('incident_type_specify')->nullable();
            $table->time('incident_time')->after('incident_date')->nullable();
            $table->string('persons_involved')->after('incident_time')->nullable();
            $table->string('exact_location')->after('persons_involved')->nullable();
            $table->text('immediate_actions')->after('incident_details')->nullable();
        });
    }

    public function down()
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->dropColumn([
                'incident_title', 'incident_type', 'incident_type_specify', 
                'incident_date', 'incident_time', 'persons_involved', 
                'exact_location', 'immediate_actions'
            ]);
        });
    }
};