<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_member_name')->nullable();
            $table->string('team_member_image')->nullable();
            $table->string('team_member_position')->nullable();
            $table->text('team_member_speech')->nullable();
            $table->text('team_member_twitter')->nullable();
            $table->text('team_member_instagram')->nullable();
            $table->text('team_member_linkedIn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_teams');
    }
};
