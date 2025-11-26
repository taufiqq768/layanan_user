# Panduan Setup Email untuk Mengirim Email Sesungguhnya

## Status Saat Ini ⚠️

Email **TIDAK benar-benar terkirim** karena menggunakan driver `log`.

Email hanya disimpan di file:
```
storage/logs/laravel.log
```

## Cara Mengirim Email Sesungguhnya

Ada beberapa pilihan service email yang bisa digunakan:

---

## ⭐ OPSI 1: Gmail (Paling Mudah - Recommended untuk Testing)

### Langkah 1: Buat App Password di Gmail

1. **Login ke akun Gmail Anda**

2. **Buka Google Account Settings**
   - Kunjungi: https://myaccount.google.com/

3. **Aktifkan 2-Step Verification** (jika belum)
   - Security → 2-Step Verification → Turn On

4. **Buat App Password**
   - Security → 2-Step Verification → App passwords
   - Pilih "Mail" dan "Other (Custom name)"
   - Masukkan nama: "Laravel Layanan User"
   - Klik "Generate"
   - **COPY password 16 digit yang muncul** (contoh: `abcd efgh ijkl mnop`)

### Langkah 2: Update File `.env`

Edit file `.env` Anda dan ubah bagian email:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=abcdefghijklmnopg
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Layanan Support"
```

**Ganti:**
- `your-email@gmail.com` → Email Gmail Anda
- `abcdefghijklmnop` → App Password yang di-generate (tanpa spasi)

### Langkah 3: Clear Config Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Langkah 4: Test Email

Coba balas pertanyaan dari dashboard admin, email akan benar-benar terkirim!

### Troubleshooting Gmail

**Problem: "Failed to authenticate"**
- Pastikan App Password benar (16 karakter tanpa spasi)
- Pastikan 2-Step Verification aktif
- Coba generate App Password baru

**Problem: "Connection timeout"**
- Pastikan port 587 tidak diblok firewall
- Coba ganti `MAIL_PORT=465` dan `MAIL_ENCRYPTION=ssl`

---

## OPSI 2: Mailtrap (Testing Email - Tidak Sampai ke User Asli)

Service untuk testing email tanpa mengirim ke user sesungguhnya.

### Setup Mailtrap:

1. **Daftar di Mailtrap**
   - https://mailtrap.io/ (Free)

2. **Get Credentials**
   - Inbox → Show Credentials → Laravel 9+

3. **Update `.env`:**

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@layanan.com"
MAIL_FROM_NAME="Layanan Support"
```

4. **Clear Cache:**
```bash
php artisan config:clear
```

**Kelebihan Mailtrap:**
- Email tidak benar-benar terkirim (aman untuk testing)
- Preview email di browser
- Cek spam score
- Check HTML/CSS rendering

---

## OPSI 3: SendGrid (Production - Gratis 100 email/hari)

Service email profesional untuk production.

### Setup SendGrid:

1. **Daftar di SendGrid**
   - https://sendgrid.com/ (Free tier: 100 emails/day)

2. **Verifikasi Email Sender**
   - Settings → Sender Authentication
   - Verify email address Anda

3. **Buat API Key**
   - Settings → API Keys → Create API Key
   - Full Access
   - Copy API Key

4. **Install Package:**
```bash
composer require symfony/sendgrid-mailer
```

5. **Update `.env`:**

```env
MAIL_MAILER=sendgrid
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.your_api_key_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="verified-email@yourdomain.com"
MAIL_FROM_NAME="Layanan Support"
```

6. **Clear Cache:**
```bash
php artisan config:clear
```

---

## OPSI 4: Mailgun (Production)

### Setup Mailgun:

1. **Daftar di Mailgun**
   - https://www.mailgun.com/ (Free trial)

2. **Get Credentials**
   - Sending → Domain Settings

3. **Update `.env`:**

```env
MAIL_MAILER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@your-domain.mailgun.org
MAIL_PASSWORD=your_mailgun_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@yourdomain.com"
MAIL_FROM_NAME="Layanan Support"

MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your_mailgun_api_key
```

---

## OPSI 5: SMTP Server Lokal (Untuk Development)

Jika Anda ingin test di localhost tanpa internet.

### Menggunakan MailHog:

1. **Install MailHog**
   - Download: https://github.com/mailhog/MailHog/releases
   - Atau via Laragon: Menu → Tools → MailHog

2. **Run MailHog**
   ```bash
   mailhog.exe
   ```

3. **Update `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="admin@layanan.local"
MAIL_FROM_NAME="Layanan Support"
```

4. **Buka UI MailHog:**
   ```
   http://localhost:8025
   ```

Email akan muncul di UI MailHog (tidak sampai ke user asli).

---

## Rekomendasi Berdasarkan Kebutuhan

### Untuk Development/Testing:
1. **Mailtrap** - Paling aman, email tidak benar-benar terkirim
2. **MailHog** - Offline, tanpa internet
3. **Gmail** - Test email sesungguhnya dengan mudah

### Untuk Production:
1. **SendGrid** - Free 100 email/hari, reliable
2. **Mailgun** - Powerful API, analytics
3. **Gmail** - OK untuk volume kecil (max 500/day)

---

## Quick Setup: Gmail (Langkah Cepat)

Jika Anda ingin **langsung test email sesungguhnya**, ikuti ini:

### 1. Siapkan Gmail App Password

```
1. Buka: https://myaccount.google.com/security
2. Aktifkan "2-Step Verification"
3. Buka "App passwords"
4. Generate password untuk "Mail"
5. COPY password 16 digit
```

### 2. Edit `.env` (hanya bagian email)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your16digitpassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="youremail@gmail.com"
MAIL_FROM_NAME="Layanan Support"
```

### 3. Restart Laravel

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test!

Balas pertanyaan dari admin dashboard → Email akan benar-benar terkirim!

---

## Verifikasi Email Terkirim

### Check di Laravel Log:

Jika masih menggunakan `MAIL_MAILER=log`:
```
storage/logs/laravel.log
```

### Check di Gmail Sent:

Jika menggunakan Gmail SMTP, cek folder "Sent" di Gmail Anda.

### Check di Mailtrap/MailHog:

Buka dashboard mereka untuk lihat email.

---

## Troubleshooting Umum

### Error: "Connection timeout"

**Penyebab:**
- Port 587 diblok firewall/antivirus
- Server SMTP tidak bisa diakses

**Solusi:**
```env
# Coba ganti port
MAIL_PORT=465
MAIL_ENCRYPTION=ssl

# Atau port lain
MAIL_PORT=2525
```

### Error: "Authentication failed"

**Penyebab:**
- Username/password salah
- Untuk Gmail: Belum pakai App Password
- Untuk Gmail: 2-Step Verification belum aktif

**Solusi:**
- Generate ulang App Password
- Pastikan copy tanpa spasi
- Pastikan username adalah email lengkap

### Error: "SSL certificate problem"

**Solusi (development only, JANGAN di production):**

Edit `config/mail.php`:
```php
'stream' => [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ],
],
```

### Email Masuk Spam

**Solusi:**
1. Gunakan domain email profesional (bukan Gmail)
2. Setup SPF, DKIM, DMARC records
3. Gunakan service seperti SendGrid/Mailgun
4. Warming up email sender

---

## Testing Email via Tinker

Test manual tanpa UI:

```bash
php artisan tinker
```

```php
use App\Mail\PertanyaanDijawab;
use App\Models\Pertanyaan;

// Test dengan pertanyaan ID 1
$pertanyaan = Pertanyaan::find(1);
Mail::to('test@example.com')->send(new PertanyaanDijawab($pertanyaan));

// Check jika ada error
// Jika sukses, tidak ada output
```

---

## File Konfigurasi Email Laravel

File config ada di:
```
config/mail.php
```

Tapi **JANGAN edit langsung**, gunakan `.env` saja.

---

## Kesimpulan

**Untuk test cepat sekarang:**
→ Gunakan **Gmail dengan App Password**

**Untuk production nanti:**
→ Gunakan **SendGrid** atau **Mailgun**

**Untuk testing tanpa kirim email asli:**
→ Gunakan **Mailtrap** atau **MailHog**

---

## Need Help?

Jika masih ada error, cek:
1. `storage/logs/laravel.log` untuk error detail
2. Pastikan `.env` sudah benar
3. Pastikan sudah `php artisan config:clear`
4. Pastikan internet/firewall tidak blok SMTP

**Happy Mailing!** 📧
