# Fitur Balas Pertanyaan dengan Email & WhatsApp

Fitur baru untuk menjawab pertanyaan pengguna dan mengirimkan jawaban secara otomatis via email dan/atau WhatsApp.

## Fitur Utama

### 1. **Halaman Balas Pertanyaan**
- Form untuk menulis jawaban
- Menampilkan informasi pertanyaan lengkap
- Input nama admin yang menjawab
- Pilihan metode pengiriman (Email/WhatsApp)
- Auto-disabled checkbox jika kontak tidak tersedia

### 2. **Pengiriman Otomatis Email**
- Template email HTML yang menarik
- Subject dinamis sesuai aplikasi
- Menampilkan pertanyaan dan jawaban
- Info admin yang menjawab dan waktu

### 3. **Pengiriman Otomatis WhatsApp**
- Format pesan WhatsApp yang rapi dengan markdown
- Auto-open WhatsApp Web/Desktop di tab baru
- Pesan sudah terformat siap kirim
- Support untuk nomor Indonesia dan internasional

### 4. **Tracking dan History**
- Menyimpan jawaban di database
- Tracking waktu dijawab (`replied_at`)
- Tracking siapa yang menjawab (`replied_by`)
- Auto-update status ke "replied"
- Menampilkan jawaban di dashboard admin

## Struktur Database

### Kolom Baru di Tabel `pertanyaan`:

| Kolom | Tipe | Deskripsi |
|-------|------|-----------|
| jawaban | text (nullable) | Jawaban dari admin |
| replied_at | timestamp (nullable) | Waktu dijawab |
| replied_by | varchar (nullable) | Nama admin yang menjawab |

## Cara Penggunaan

### Untuk Admin:

1. **Masuk ke Dashboard Admin**
   ```
   http://localhost/layanan_user/admin/layanan
   ```

2. **Klik Tombol "Balas Pertanyaan"**
   - Tombol ada di setiap pertanyaan
   - Jika sudah dijawab, tombol berubah jadi "Edit Jawaban"

3. **Isi Form Jawaban**
   - Masukkan nama Anda sebagai admin
   - Tulis jawaban untuk pertanyaan
   - Pilih metode pengiriman:
     - ✅ **Email** - Jika user memberikan email
     - ✅ **WhatsApp** - Jika user memberikan nomor WA
     - Bisa pilih keduanya sekaligus

4. **Klik "Kirim Jawaban"**
   - Jawaban akan tersimpan di database
   - Email dikirim otomatis (jika dipilih)
   - WhatsApp Web terbuka otomatis (jika dipilih)
   - Status pertanyaan berubah jadi "replied"

## Alur Kerja

```
User Submit Pertanyaan
  ↓
Admin Lihat di Dashboard
  ↓
Admin Klik "Balas Pertanyaan"
  ↓
Admin Isi Form Jawaban
  ↓
Admin Pilih Metode Pengiriman
  ↓
Klik "Kirim Jawaban"
  ↓
┌─────────────────┬────────────────────┐
│                 │                    │
Email Terkirim   WhatsApp Terbuka    Data Tersimpan
(otomatis)       (auto-open)          di Database
│                 │                    │
└─────────────────┴────────────────────┘
  ↓
User Menerima Jawaban
```

## Template Email

Email menggunakan template HTML profesional dengan:
- Header gradient sesuai brand
- Badge aplikasi
- Section pertanyaan dengan border
- Section jawaban dengan highlight hijau
- Info admin dan tanggal
- Footer dengan disclaimer

### Preview Email:
```
┌────────────────────────────────────┐
│   Pertanyaan Anda Telah Dijawab   │
│         [Badge: Nadine]            │
├────────────────────────────────────┤
│ Tanggal: 20/11/2025 10:30          │
│ Dijawab oleh: Admin Support        │
│ Dijawab pada: 20/11/2025 15:45     │
├────────────────────────────────────┤
│ Pertanyaan Anda:                   │
│ [Pertanyaan user di sini...]       │
├────────────────────────────────────┤
│ Jawaban:                           │
│ [Jawaban admin di sini...]         │
├────────────────────────────────────┤
│ Terima kasih telah menggunakan     │
│ layanan kami.                      │
└────────────────────────────────────┘
```

## Format Pesan WhatsApp

```
*Jawaban untuk Pertanyaan Anda*

*Aplikasi:* Nadine
*Pertanyaan Anda:*
Bagaimana cara reset password?

*Jawaban:*
Untuk reset password, silakan klik tombol
"Lupa Password" di halaman login...

_Dijawab oleh: Admin Support_
_Tanggal: 20/11/2025 15:45_
```

## Routes yang Ditambahkan

| Method | URI | Nama Route | Fungsi |
|--------|-----|------------|--------|
| GET | `/admin/layanan/{id}/reply` | layanan.reply | Halaman form balas |
| POST | `/admin/layanan/{id}/reply` | layanan.sendReply | Kirim jawaban |

## Konfigurasi Email

### Development (Testing)
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="admin@layanan.com"
MAIL_FROM_NAME="Layanan Support"
```
Email akan tersimpan di `storage/logs/laravel.log`

### Production (SMTP Real)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@layanan.com"
MAIL_FROM_NAME="Layanan Support"
```

### Menggunakan Gmail:
1. Buat App Password di Google Account
2. Update `.env` dengan credentials
3. Restart Laravel

## Validasi Form Balas

### Client-Side:
- Jawaban wajib diisi
- Nama admin wajib diisi
- Minimal 1 metode pengiriman dipilih

### Server-Side:
- Validasi jawaban tidak kosong
- Validasi nama admin tidak kosong
- Validasi minimal 1 kontak dipilih
- Auto-check ketersediaan email/whatsapp

## Error Handling

### Email Gagal Dikirim:
- Jawaban tetap tersimpan di database
- Pesan error ditampilkan: "Gagal mengirim email: [error]"
- Status tetap berubah ke "replied"
- Admin bisa kirim manual via mailto

### WhatsApp Tidak Terbuka:
- Pesan WhatsApp sudah disiapkan
- Link tersimpan di session
- Admin bisa copy-paste manual
- Alternatif: Scan QR code di WA Web

## Keamanan

- ✅ CSRF Token protection
- ✅ XSS prevention dengan `e()` helper
- ✅ SQL Injection prevention dengan Eloquent
- ✅ Email sanitization
- ✅ WhatsApp number validation
- ✅ Input validation server & client

## Fitur Tambahan

### 1. Edit Jawaban
- Admin bisa edit jawaban yang sudah dikirim
- Tombol "Balas" berubah jadi "Edit Jawaban"
- Form ter-isi dengan jawaban sebelumnya

### 2. History Jawaban
- Menampilkan siapa yang menjawab
- Menampilkan kapan dijawab
- Menampilkan jawaban di dashboard

### 3. Multi-Channel
- Bisa kirim ke email dan WhatsApp sekaligus
- Bisa pilih salah satu saja
- Flexible sesuai kebutuhan

## Troubleshooting

### Email Tidak Terkirim
**Problem:** Email tidak masuk ke inbox user

**Solusi:**
1. Cek `storage/logs/laravel.log` (jika MAIL_MAILER=log)
2. Pastikan SMTP credentials benar
3. Cek spam folder
4. Test dengan command:
   ```bash
   php artisan tinker
   Mail::raw('Test', function($msg) {
       $msg->to('test@email.com')->subject('Test');
   });
   ```

### WhatsApp Tidak Terbuka
**Problem:** WhatsApp Web tidak auto-open

**Solusi:**
1. Pastikan browser mengizinkan pop-up
2. Cek console browser untuk error
3. Copy link manual dari response
4. Gunakan mailto sebagai alternatif

### Jawaban Tidak Tersimpan
**Problem:** Form submit tapi data tidak tersimpan

**Solusi:**
1. Cek console browser untuk error
2. Cek Laravel log di `storage/logs/`
3. Pastikan migration sudah dijalankan
4. Cek fillable di Model Pertanyaan

## Pengembangan Lebih Lanjut

### Rekomendasi:
1. **WhatsApp API Integration**
   - Gunakan WhatsApp Business API
   - Kirim otomatis tanpa manual
   - Lebih profesional

2. **Email Template Builder**
   - Drag & drop editor
   - Custom template per aplikasi
   - Variable placeholder

3. **Notifikasi Real-time**
   - WebSocket untuk notif langsung
   - Push notification
   - Email notification ke admin

4. **Attachment Support**
   - Upload file lampiran
   - Image support
   - PDF support

5. **Canned Responses**
   - Template jawaban cepat
   - Keyword shortcuts
   - Auto-suggest

6. **Analytics**
   - Response time tracking
   - Admin performance
   - User satisfaction rating

## File-file yang Dibuat/Dimodifikasi

### Migration:
- `2025_11_20_040627_add_jawaban_to_pertanyaan_table.php`

### Model:
- `app/Models/Pertanyaan.php` (updated fillable & casts)

### Controller:
- `app/Http/Controllers/LayananController.php` (added showReplyForm & sendReply)

### Views:
- `resources/views/layanan/reply.blade.php` (new)
- `resources/views/layanan/admin.blade.php` (updated)
- `resources/views/emails/pertanyaan-dijawab.blade.php` (new)

### Mail:
- `app/Mail/PertanyaanDijawab.php` (new)

### Routes:
- `routes/web.php` (added reply routes)

## Testing

### Manual Testing:
1. Submit pertanyaan dari halaman user
2. Masuk ke admin dashboard
3. Klik "Balas Pertanyaan"
4. Isi form dan kirim
5. Cek email di `storage/logs/laravel.log`
6. Cek WhatsApp terbuka otomatis
7. Verify data tersimpan di database

### Database Check:
```sql
SELECT id, aplikasi, pertanyaan, jawaban, replied_by, replied_at, status
FROM pertanyaan
WHERE jawaban IS NOT NULL;
```

---

**Fitur Balas Pertanyaan Siap Digunakan!**

Dengan fitur ini, admin bisa memberikan layanan yang lebih cepat dan profesional kepada pengguna.