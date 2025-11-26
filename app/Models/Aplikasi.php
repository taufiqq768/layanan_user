<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplikasi extends Model
{
    protected $table = 'aplikasi';

    protected $fillable = [
        'inisial',
        'nama',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scope untuk hanya aplikasi aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relasi ke admin_aplikasi
    public function adminAplikasi()
    {
        return $this->hasMany(AdminAplikasi::class, 'aplikasi', 'inisial');
    }
}
