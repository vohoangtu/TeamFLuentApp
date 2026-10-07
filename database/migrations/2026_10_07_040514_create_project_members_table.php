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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->string('role_in_project')->default('Contributor'); // Lead, Tech Lead, Senior Developer, Designer, QA, Contributor
            $table->unsignedTinyInteger('allocation_percent')->default(50); // % workload (e.g., 20, 40, 50, 80, 100)
            $table->date('assigned_at')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
