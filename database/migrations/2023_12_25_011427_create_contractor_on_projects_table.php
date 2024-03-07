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
        Schema::create('contractor_on_project', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('project_summary_id');
            $table->string('contractor_id');
            $table->string('contractor_name');
            $table->string('contact');
            $table->string('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_on_projects');
    }
};
