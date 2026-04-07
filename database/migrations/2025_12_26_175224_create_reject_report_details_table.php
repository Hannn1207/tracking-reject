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
        Schema::create('reject_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reject_report_id')
                ->constrained('reject_reports')
                ->cascadeOnDelete();

            $table->foreignId('reject_type_id')
                ->constrained('reject_types')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->integer('qty_reject');
            $table->enum('status_reject', ['NG', 'OK', 'REP'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reject_report_details');
    }
};
