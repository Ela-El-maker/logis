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
        Schema::create('customer_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('feedback_name')->nullable();
            $table->text('feedback_email')->nullable();
            $table->string('feedback_company')->nullable();
            $table->string('feedback_position')->nullable();
            $table->string('feedback_phone')->nullable();
            $table->text('feedback_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_feedback');
    }
};
