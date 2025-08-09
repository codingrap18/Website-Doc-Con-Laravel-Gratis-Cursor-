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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('document_title');
            $table->string('revision')->default('NS');
            $table->enum('status', ['NS', 'IFR', 'RIFR', 'IFA', 'RIFA', 'IFC', 'RIFC', 'IFI'])->default('NS');
            $table->timestamp('submission_date')->nullable();
            $table->timestamp('target_date')->nullable();
            $table->foreignId('latest_reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('submit_to_reviewer_date')->nullable();
            $table->string('document_position')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['submission_date']);
            $table->index(['target_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
