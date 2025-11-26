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
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->string('aplikasi'); // Inisial aplikasi (Nadine, DFarm, dll)
            $table->text('pertanyaan'); // Pertanyaan FAQ
            $table->text('jawaban'); // Jawaban FAQ
            $table->integer('urutan')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();

            // Index untuk performa
            $table->index('aplikasi');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
