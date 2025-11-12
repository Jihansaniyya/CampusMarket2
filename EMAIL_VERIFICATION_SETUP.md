# Email Verification Configuration Guide

## 📧 Setup Email untuk Testing (Development)

### Option 1: Mailtrap (Recommended untuk Development)

1. **Buat akun gratis di** [Mailtrap.io](https://mailtrap.io)
2. **Login dan buka SMTP Settings**
3. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

### Option 2: Gmail SMTP (untuk Production)

1. **Enable 2-Step Verification di Google Account**
2. **Generate App Password**: 
   - Go to: https://myaccount.google.com/apppasswords
   - Pilih "Mail" dan "Other (Custom name)"
   - Copy password yang di-generate

3. **Update file `.env`**:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_16_digit_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="CampusMarket"
```

### Option 3: Log Driver (untuk Testing tanpa Email Real)

Email akan disimpan di `storage/logs/laravel.log`:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

## 🚀 Cara Menggunakan

### 1. Jalankan Migration

```bash
php artisan migrate
```

### 2. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Registrasi

1. Buka: http://localhost:8000/register
2. Isi form registrasi
3. Submit form
4. Akan redirect ke halaman "Verify Email"
5. Cek email (atau Mailtrap inbox, atau `storage/logs/laravel.log` jika pakai log driver)
6. Klik link verifikasi
7. Email terverifikasi! 🎉

## 📝 Flow Email Verification

1. **User Register** → Email verification dikirim otomatis
2. **User Login tanpa verify** → Ditolak dengan pesan error
3. **User klik link di email** → Email verified
4. **User login** → Berhasil masuk ke dashboard

## 🔒 Security Features

- ✅ Signed URL untuk keamanan link verifikasi
- ✅ Rate limiting (max 6 request per menit untuk resend)
- ✅ User tidak bisa login sebelum verify email
- ✅ Email hashing di URL untuk prevent tampering

## 🎨 Customization

### Custom Email Template (Optional)

Jika ingin custom template email verification:

```bash
php artisan vendor:publish --tag=laravel-notifications
```

Edit file: `resources/views/vendor/notifications/email.blade.php`

## 🐛 Troubleshooting

### Email tidak terkirim?

1. Cek `.env` sudah benar
2. Jalankan: `php artisan config:clear`
3. Cek `storage/logs/laravel.log` untuk error
4. Pastikan MAIL_FROM_ADDRESS valid

### Link verification expired?

- Link valid 60 menit by default
- User bisa klik "Kirim Ulang Email Verifikasi"

### Testing di Local?

- Gunakan Mailtrap (fake SMTP)
- Atau gunakan `MAIL_MAILER=log` dan cek `storage/logs/laravel.log`

## 📌 Notes

- Email verification wajib sebelum login
- User bisa resend verification email max 6x per menit
- Link verification menggunakan signed URL (secure)
- Support untuk semua role: buyer, seller, admin
