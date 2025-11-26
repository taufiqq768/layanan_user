<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAplikasi extends Model
{
    protected $table = 'admin_aplikasi';

    protected $fillable = [
        'admin_id',
        'aplikasi',
    ];

    // Relasi ke Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Relasi ke Aplikasi
    public function aplikasiData()
    {
        return $this->belongsTo(Aplikasi::class, 'aplikasi', 'inisial');
    }
}
