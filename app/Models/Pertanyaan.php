<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaan';

    protected $fillable = [
        'nomor_tiket',
        'aplikasi',
        'pertanyaan',
        'gambar',
        'jawaban',
        'gambar_jawaban',
        'email',
        'whatsapp',
        'ip_address',
        'status',
        'replied_at',
        'replied_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Boot method untuk auto-generate nomor tiket
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pertanyaan) {
            if (empty($pertanyaan->nomor_tiket)) {
                $pertanyaan->nomor_tiket = static::generateNomorTiket();
            }
        });
    }

    /**
     * Generate nomor tiket dengan format YYYYMMDD-#XXXXX
     */
    public static function generateNomorTiket()
    {
        $date = date('Ymd');

        // Hitung jumlah pertanyaan hari ini
        $count = static::whereDate('created_at', today())->count() + 1;

        // Format: YYYYMMDD-#XXXXX
        return $date . '-#' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    // Scope untuk filter berdasarkan aplikasi
    public function scopeByAplikasi($query, $aplikasi)
    {
        return $query->where('aplikasi', $aplikasi);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor untuk format WhatsApp link
    public function getWhatsappLinkAttribute()
    {
        if (empty($this->whatsapp)) {
            return null;
        }
        $cleanNumber = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$cleanNumber}";
    }
}
