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
        Schema::create('project_summary', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_project');
            $table->string('project_name');
            $table->string('building_name');
            $table->string('project_owner');
            $table->year('year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_summaries');
    }
};
