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
        Schema::create('reject_reports', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');
            $table->string('meja');
            $table->string('line');
            $table->enum('shift', ['1', '2', '3']);
            $table->string('lot_number')->unique();
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->foreignId('part_id')
                ->constrained('name_parts')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reject_reports');
    }
};
