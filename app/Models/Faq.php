<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';

    protected $fillable = [
        'aplikasi',
        'pertanyaan',
        'jawaban',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope untuk hanya FAQ aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter berdasarkan aplikasi
    public function scopeByAplikasi($query, $aplikasi)
    {
        return $query->where('aplikasi', $aplikasi);
    }

    // Relasi ke aplikasi
    public function aplikasiRelation()
    {
        return $this->belongsTo(Aplikasi::class, 'aplikasi', 'inisial');
    }
}
