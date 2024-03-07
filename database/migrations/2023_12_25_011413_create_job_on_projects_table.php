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
        Schema::create('job_on_project', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('project_summary_id');
            $table->string('job_id');
            $table->string('job_name');
            $table->string('desc');
            $table->double('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_on_projects');
    }
};
