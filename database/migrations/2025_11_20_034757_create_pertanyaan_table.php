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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('aplikasi'); // Nama aplikasi (Nadine, DFarm, dll)
            $table->text('pertanyaan'); // Pertanyaan dari user
            $table->string('email')->nullable(); // Email user (opsional)
            $table->string('whatsapp')->nullable(); // Nomor WhatsApp (opsional)
            $table->ipAddress('ip_address')->nullable(); // IP Address user
            $table->enum('status', ['pending', 'replied', 'closed'])->default('pending'); // Status pertanyaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
