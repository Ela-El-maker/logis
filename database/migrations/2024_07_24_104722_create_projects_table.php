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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_category_id')->nullable();
            $table->string('project_name')->nullable();
            $table->string('project_icon')->nullable();
            $table->text('project_title')->nullable();
            $table->text('project_sub_title')->nullable();
            $table->text('project_description')->nullable();
            $table->text('project_image')->nullable();
            $table->text('project_image_1')->nullable();
            $table->text('project_image_2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
