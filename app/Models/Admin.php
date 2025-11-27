<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Automatically append attribute accessors when serializing
    protected $appends = ['aplikasi_list'];

    // Relasi many-to-many dengan aplikasi
    public function aplikasi()
    {
        return $this->hasMany(AdminAplikasi::class);
    }

    // Alias untuk compatibility
    public function adminAplikasi()
    {
        return $this->hasMany(AdminAplikasi::class);
    }

    // Helper method untuk cek apakah admin handle aplikasi tertentu
    public function handlesAplikasi($aplikasi)
    {
        return $this->aplikasi()->where('aplikasi', $aplikasi)->exists();
    }

    // Helper method untuk get daftar aplikasi yang di-handle
    public function getAplikasiListAttribute()
    {
        return $this->aplikasi()->pluck('aplikasi')->toArray();
    }

    // Scope untuk filter admin berdasarkan aplikasi
    public function scopeHandlesAplikasi($query, $aplikasi)
    {
        return $query->whereHas('aplikasi', function ($q) use ($aplikasi) {
            $q->where('aplikasi', $aplikasi);
        });
    }
}
