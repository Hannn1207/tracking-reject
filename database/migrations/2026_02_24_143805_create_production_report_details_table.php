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
        Schema::create('production_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_report_id')
                ->constrained('production_reports')
                ->cascadeOnDelete();
            $table->foreignId('target_id')
                ->constrained('targets')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('kode')->nullable();
            $table->integer('qty_scan')
                ->nullable();
            $table->string('no_lot');
            $table->integer('ok')->default(0);
            $table->integer('ng')->default(0);
            $table->integer('repair')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_report_details');
    }
};
