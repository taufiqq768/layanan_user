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
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->string('nomor_tiket', 50)->nullable()->after('id');
        });

        // Generate nomor tiket untuk data yang sudah ada
        $pertanyaans = DB::table('pertanyaan')->get();
        foreach ($pertanyaans as $pertanyaan) {
            $date = date('Ymd', strtotime($pertanyaan->created_at));
            $counter = DB::table('pertanyaan')
                ->where('created_at', '>=', date('Y-m-d 00:00:00', strtotime($pertanyaan->created_at)))
                ->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime($pertanyaan->created_at)))
                ->where('id', '<=', $pertanyaan->id)
                ->count();

            $nomorTiket = $date . '-#' . str_pad($counter, 5, '0', STR_PAD_LEFT);

            DB::table('pertanyaan')
                ->where('id', $pertanyaan->id)
                ->update(['nomor_tiket' => $nomorTiket]);
        }

        // Setelah data diisi, buat unique constraint
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->unique('nomor_tiket');
            $table->index('nomor_tiket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropIndex(['nomor_tiket']);
            $table->dropColumn('nomor_tiket');
        });
    }
};
