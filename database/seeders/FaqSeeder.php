<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqList = [
            // FAQ Nadine
            [
                'aplikasi' => 'Nadine',
                'pertanyaan' => 'Bagaimana cara login ke aplikasi Nadine?',
                'jawaban' => 'Anda dapat login menggunakan email dan password yang telah terdaftar. Jika lupa password, klik tombol "Lupa Password" di halaman login.',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'aplikasi' => 'Nadine',
                'pertanyaan' => 'Apa yang harus dilakukan jika data tidak muncul?',
                'jawaban' => 'Pastikan koneksi internet Anda stabil. Coba refresh halaman atau logout kemudian login kembali. Jika masalah berlanjut, hubungi admin.',
                'urutan' => 2,
                'is_active' => true,
            ],

            // FAQ DFarm
            [
                'aplikasi' => 'DFarm',
                'pertanyaan' => 'Bagaimana cara menambahkan data lahan baru?',
                'jawaban' => 'Masuk ke menu "Manajemen Lahan", klik tombol "Tambah Lahan Baru", isi form yang tersedia dengan lengkap, kemudian klik "Simpan".',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'aplikasi' => 'DFarm',
                'pertanyaan' => 'Bagaimana cara melihat laporan hasil panen?',
                'jawaban' => 'Buka menu "Laporan" > "Hasil Panen", pilih periode dan lahan yang ingin dilihat, kemudian klik "Tampilkan Laporan".',
                'urutan' => 2,
                'is_active' => true,
            ],

            // FAQ HRIS
            [
                'aplikasi' => 'HRIS',
                'pertanyaan' => 'Bagaimana cara mengajukan cuti?',
                'jawaban' => 'Login ke HRIS, pilih menu "Cuti", klik "Ajukan Cuti Baru", pilih jenis cuti, tanggal mulai dan selesai, isi alasan, kemudian submit untuk approval atasan.',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'aplikasi' => 'HRIS',
                'pertanyaan' => 'Dimana saya bisa melihat slip gaji?',
                'jawaban' => 'Slip gaji dapat diunduh di menu "Penggajian" > "Slip Gaji". Pilih bulan yang diinginkan dan klik "Download PDF".',
                'urutan' => 2,
                'is_active' => true,
            ],

            // FAQ ARHAN
            [
                'aplikasi' => 'ARHAN',
                'pertanyaan' => 'Bagaimana cara upload dokumen ke sistem?',
                'jawaban' => 'Pilih menu "Upload Dokumen", klik "Browse" untuk memilih file dari komputer, isi metadata dokumen (judul, kategori, dll), kemudian klik "Upload".',
                'urutan' => 1,
                'is_active' => true,
            ],

            // FAQ MONIKA
            [
                'aplikasi' => 'MONIKA',
                'pertanyaan' => 'Bagaimana cara melihat dashboard monitoring?',
                'jawaban' => 'Dashboard monitoring dapat diakses langsung setelah login. Pilih periode dan filter yang diinginkan untuk melihat data monitoring secara real-time.',
                'urutan' => 1,
                'is_active' => true,
            ],

            // FAQ MAIA
            [
                'aplikasi' => 'MAIA',
                'pertanyaan' => 'Apa fungsi utama aplikasi MAIA?',
                'jawaban' => 'MAIA adalah sistem manajemen aplikasi internal untuk mengelola, memonitor, dan mengontrol semua aplikasi yang ada di perusahaan secara terpusat.',
                'urutan' => 1,
                'is_active' => true,
            ],

            // FAQ StakeHolder
            [
                'aplikasi' => 'StakeHolder',
                'pertanyaan' => 'Bagaimana cara mengakses portal stakeholder?',
                'jawaban' => 'Akses portal melalui link yang diberikan oleh admin. Login menggunakan kredensial yang telah didaftarkan. Jika belum memiliki akun, hubungi administrator.',
                'urutan' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($faqList as $faq) {
            Faq::create($faq);
        }
    }
}
