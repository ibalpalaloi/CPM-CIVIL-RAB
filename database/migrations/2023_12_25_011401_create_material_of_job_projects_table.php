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
        Schema::create('material_of_job_project', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('project_summary_id');
            $table->string('job_on_project_id');
            $table->string('material_category_id');
            $table->string('material_category_name');
            $table->string('sub_material_category_id');
            $table->string('sub_material_category_name');
            $table->string('material_id');
            $table->string('material_name');
            $table->double('qty');
            $table->string('unit');
            $table->double('price');
            $table->string('area');
            $table->string('desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_of_job_projects');
    }
};
