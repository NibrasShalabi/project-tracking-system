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
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('week_id');
            $table->unsignedBigInteger('student_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['to_do', 'in_progress', 'done'])->default('to_do');
            $table->date('start_date')->nullable();
            $table->date('duer_date')->nullable();
            $table->text('note_supervisor')->nullable();
            $table->text('note_student')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('week_id')->references('id')->on('project_weeks')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('project_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tasks');
    }
};
