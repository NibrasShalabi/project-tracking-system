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
            $table->string('title');
            $table->text('description');
            $table->string('field');
            $table->enum('type', ['graduation', 'applicational', 'pre_graduation']);
            $table->enum('status', ['proposed', 'in_progress', 'completed']);
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('coordinator_id');
            $table->date('start_date');
            $table->string('cover_image')->nullable();
            $table->timestamps();

            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('coordinator_id')->references('id')->on('project_users')->onDelete('cascade');
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
