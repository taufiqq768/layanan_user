# Aplikasi Layanan Pengguna - Laravel Version

Aplikasi web untuk menerima pertanyaan dari pengguna dengan pilihan aplikasi (Nadine, DFarm, dll) dan kontak email atau WhatsApp.

## Fitur Utama

### Untuk Pengguna
- **Dropdown Pilihan Aplikasi**: Nadine, DFarm, atau Lainnya
- **Form Pertanyaan** dengan validasi client-side dan server-side
- **Input Email dan/atau WhatsApp** (minimal satu wajib diisi)
- **Responsive Design** untuk mobile dan desktop
- **Real-time Validation** saat mengisi form

### Untuk Admin
- **Dashboard Statistik**:
  - Total pertanyaan
  - Status: Pending, Replied, Closed
  - Jumlah dengan Email/WhatsApp
- **Filter dan Search**:
  - Filter berdasarkan aplikasi
  - Filter berdasarkan status
- **Manajemen Status**:
  - Update status pertanyaan
  - Pending → Replied → Closed
- **Quick Action**:
  - Link langsung ke email (mailto)
  - Link langsung ke WhatsApp chat
- **Tracking**: IP Address pengguna

## Struktur Database

### Tabel: `pertanyaan`

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| id | bigint | Primary key |
| aplikasi | varchar | Nama aplikasi (Nadine, DFarm, dll) |
| pertanyaan | text | Pertanyaan dari user |
| email | varchar (nullable) | Email user |
| whatsapp | varchar (nullable) | Nomor WhatsApp |
| ip_address | varchar (nullable) | IP Address user |
| status | enum | pending, replied, closed |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

## Struktur File Laravel

```
layanan_user/
├── app/
│   ├── Http/Controllers/
│   │   └── LayananController.php      # Controller utama
│   └── Models/
│       └── Pertanyaan.php              # Model Eloquent
├── database/
│   └── migrations/
│       └── 2025_11_20_034757_create_pertanyaan_table.php
├── resources/views/layanan/
│   ├── index.blade.php                 # Halaman form user
│   └── admin.blade.php                 # Dashboard admin
└── routes/
    └── web.php                          # Routing aplikasi
```

## Routes

| Method | URI | Nama Route | Deskripsi |
|--------|-----|------------|-----------|
| GET | `/` | layanan.index | Halaman form user |
| POST | `/layanan/submit` | layanan.store | Submit pertanyaan |
| GET | `/admin/layanan` | layanan.admin | Dashboard admin |
| POST | `/admin/layanan/{id}/status` | layanan.updateStatus | Update status |

## Instalasi

### 1. Konfigurasi Database

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=layanan_user
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Buat Database

```bash
mysql -u root -e "CREATE DATABASE layanan_user CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Jalankan Migration

```bash
php artisan migrate --database=mysql
```

Atau jika sudah setup .env dengan benar:
```bash
php artisan migrate
```

### 4. Akses Aplikasi

- **User**: `http://localhost/layanan_user/`
- **Admin**: `http://localhost/layanan_user/admin/layanan`

## Cara Penggunaan

### Untuk Pengguna

1. Buka halaman utama aplikasi
2. Pilih aplikasi dari dropdown (Nadine, DFarm, atau Lainnya)
3. Tuliskan pertanyaan Anda
4. Isi email dan/atau nomor WhatsApp (minimal satu)
5. Klik "Kirim Pertanyaan"
6. Tunggu admin menghubungi Anda

### Untuk Admin

1. Buka dashboard admin
2. Lihat statistik pertanyaan
3. Filter berdasarkan aplikasi atau status
4. Klik email untuk mengirim balasan via email
5. Klik WhatsApp untuk chat langsung
6. Update status pertanyaan:
   - **Pending**: Pertanyaan baru
   - **Replied**: Sudah dibalas
   - **Closed**: Selesai/ditutup

## Validasi

### Client-Side (JavaScript)
- Aplikasi wajib dipilih
- Pertanyaan wajib diisi
- Minimal satu kontak (email atau WhatsApp)
- Format email harus valid
- WhatsApp minimal 10 digit

### Server-Side (Laravel)
- Validasi ulang semua input
- Sanitasi data untuk mencegah XSS
- Custom validation untuk kontak
- CSRF Protection

## Keamanan

- **CSRF Token** untuk semua form POST
- **XSS Protection** dengan htmlspecialchars
- **SQL Injection Prevention** dengan Eloquent ORM
- **Input Validation** client dan server side
- **IP Tracking** untuk monitoring

## Model Eloquent Features

### Scopes
```php
// Filter berdasarkan aplikasi
Pertanyaan::byAplikasi('Nadine')->get();

// Filter berdasarkan status
Pertanyaan::byStatus('pending')->get();
```

### Accessor
```php
// WhatsApp link otomatis
$pertanyaan->whatsapp_link; // https://wa.me/628123456789
```

## Customization

### Menambah Aplikasi Baru

Edit [LayananController.php](app/Http/Controllers/LayananController.php#L14-L18):
```php
$aplikasiList = [
    'Nadine' => 'Nadine',
    'DFarm' => 'DFarm',
    'Aplikasi Baru' => 'Aplikasi Baru', // Tambahkan di sini
    'Lainnya' => 'Lainnya'
];
```

### Mengubah Status Options

Edit migration dan enum di database jika ingin menambah status baru.

## API Endpoints (JSON Response)

### Submit Pertanyaan
```
POST /layanan/submit
Content-Type: multipart/form-data

Response Success:
{
  "success": true,
  "message": "Pertanyaan Anda berhasil dikirim!"
}

Response Error:
{
  "success": false,
  "message": "Error message here"
}
```

### Update Status
```
POST /admin/layanan/{id}/status
Content-Type: application/json

Body:
{
  "status": "replied"
}

Response:
{
  "success": true,
  "message": "Status berhasil diupdate"
}
```

## Pengembangan Lebih Lanjut

### Rekomendasi
1. **Authentication**: Tambahkan Laravel Breeze/Jetstream untuk admin
2. **Email Notification**: Kirim email ke admin saat pertanyaan baru
3. **Pagination**: Untuk banyak data di admin
4. **Export**: Export data ke Excel/CSV
5. **Rich Text Editor**: Untuk reply admin
6. **File Upload**: Attachment untuk pertanyaan
7. **Real-time**: WebSocket untuk notifikasi real-time
8. **Analytics**: Grafik statistik pertanyaan
9. **Search**: Full-text search pertanyaan
10. **API**: REST API untuk integrasi aplikasi lain

### Integrasi dengan Aplikasi Lain

Karena menggunakan database MySQL, aplikasi lain dapat:
- Query langsung ke tabel `pertanyaan`
- Gunakan REST API (jika dibuat)
- Shared database connection
- Event broadcasting untuk real-time sync

## Troubleshooting

### Migration Error "could not find driver"
```bash
# Clear cache
php artisan config:clear
rm -rf bootstrap/cache/*.php

# Run migration dengan explicit database
php artisan migrate --database=mysql --force
```

### CSRF Token Mismatch
Pastikan `<meta name="csrf-token">` ada di head dan JavaScript menggunakan token tersebut.

### Database Connection Failed
Periksa:
1. MySQL service sudah running (Laragon)
2. Database sudah dibuat
3. Kredensial di `.env` benar
4. Clear config cache

## Tech Stack

- **Backend**: Laravel 11.x
- **Database**: MySQL 8.x
- **Frontend**: Blade Template, Vanilla JavaScript
- **CSS**: Custom CSS dengan Gradient
- **Server**: Laragon (Apache + MySQL + PHP)

## Lisensi

Free to use and modify for your projects.

---

**Developed with Laravel Framework**