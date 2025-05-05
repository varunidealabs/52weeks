<?php
// database/migrations/0001_01_01_000003_create_journals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('week_number');
            $table->unsignedInteger('year');
            $table->timestamps();
            
            // Each user can have only one journal per week in a year
            $table->unique(['user_id', 'week_number', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};