<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('total_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reject_report_id')->constrained('reject_reports')->unique()->onDelete('cascade');

            $table->unsignedBigInteger('total_reject_fg')->default(0);
            $table->unsignedBigInteger('total_reject_stl_htr')->default(0);
            $table->unsignedBigInteger('total_reject_mc')->default(0);
            $table->unsignedBigInteger('total_reject_inpk')->default(0);
            $table->unsignedBigInteger('total_reject')->default(0);
            $table->unsignedBigInteger('total_qty_proses')->default(0);
            $table->unsignedBigInteger('total_repair')->default(0);
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('total_produksi');
    }
};
