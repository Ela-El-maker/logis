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
        Schema::create('summary_programs', function (Blueprint $table) {
            $table->id();
            $table->string('summary_clients')->nullable();
            $table->string('summary_projects')->nullable();
            $table->string('summary_support')->nullable();
            $table->string('summary_workers')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summary_programs');
    }
};
