# 🎉 Email Verification - SUDAH TERIMPLEMENTASI!

## ✅ Yang Sudah Dibuat

### 1. **Database Schema**
- ✅ Kolom `email_verified_at` di tabel `users`
- ✅ Kolom tambahan untuk buyer & seller (role, phone, address, store info, dll)

### 2. **Authentication Flow**
- ✅ User Model implement `MustVerifyEmail`
- ✅ Registration mengirim email verifikasi otomatis
- ✅ Login diblokir jika email belum diverifikasi
- ✅ Redirect berdasarkan role setelah login

### 3. **Email Verification Pages**
- ✅ Halaman "Verify Email" dengan desain menarik
- ✅ Tombol "Resend Verification Email"
- ✅ Rate limiting (max 6x per menit)

### 4. **Security**
- ✅ Signed URL untuk link verifikasi
- ✅ Middleware `verified` untuk proteksi route
- ✅ Role-based middleware (`role:admin`, `role:seller`, `role:buyer`)

### 5. **Dashboard**
- ✅ Buyer Dashboard
- ✅ Seller Dashboard
- ✅ Admin Dashboard (sudah ada sebelumnya)

---

## 🚀 CARA TESTING

### Step 1: Setup Email Configuration

**Pilih salah satu:**

#### Option A: Mailtrap (Recommended - Gratis & Mudah)

1. Daftar di https://mailtrap.io (gratis)
2. Buat inbox baru
3. Copy SMTP credentials
4. Edit file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username_here
MAIL_PASSWORD=your_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

#### Option B: Gmail SMTP (untuk Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your_email@gmail.com"
MAIL_FROM_NAME="CampusMarket"
```

**PENTING untuk Gmail:**
- Enable 2-Step Verification di Google Account
- Generate App Password di: https://myaccount.google.com/apppasswords
- Gunakan 16-digit app password (bukan password biasa!)

#### Option C: Log Driver (Testing tanpa email real)

Email akan tersimpan di `storage/logs/laravel.log`:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

---

### Step 2: Jalankan Server

```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite (untuk Tailwind CSS)
npm run dev
```

---

### Step 3: Test Registration Flow

#### A. Test sebagai BUYER

1. **Buka:** http://localhost:8000/register
2. **Isi form:**
   - Full Name: `John Doe`
   - Email: `buyer@test.com`
   - Phone: `081234567890`
   - Password: `Password123`
   - Confirm Password: `Password123`
   - **Role: BUYER** ✅
   - Check "Terms & Conditions"
3. **Submit** → Akan redirect ke halaman "Verify Email"
4. **Cek Email:**
   - Mailtrap: Buka inbox di Mailtrap.io
   - Gmail: Cek inbox Gmail
   - Log: Buka `storage/logs/laravel.log`, cari URL verification
5. **Klik link verifikasi** → Email terverifikasi! ✅
6. **Login** dengan buyer@test.com → Masuk ke **Buyer Dashboard** 🎉

#### B. Test sebagai SELLER

1. **Buka:** http://localhost:8000/register
2. **Isi form:**
   - Full Name: `Jane Smith`
   - Email: `seller@test.com`
   - Phone: `081234567891`
   - Password: `Password123`
   - Confirm Password: `Password123`
   - **Role: SELLER** ✅ (akan muncul form tambahan!)
3. **Isi form seller tambahan:**
   - Nama Toko: `Jane Store`
   - Deskripsi: `Best products in campus`
   - PIC Name: `Jane Smith`
   - No HP PIC: `081234567891`
   - Alamat: `Jl. Kampus No. 123`
   - (isi field lainnya optional)
4. **Submit** → Redirect ke "Verify Email"
5. **Cek email & klik link verifikasi**
6. **Login** → Masuk ke **Seller Dashboard** dengan info toko! 🏪

---

### Step 4: Test Login tanpa Verifikasi

1. **Register akun baru** (jangan klik link verifikasi)
2. **Logout** (jika masih login)
3. **Login** dengan akun yang belum diverifikasi
4. **Result:** ❌ Login ditolak dengan pesan:
   ```
   Email Anda belum diverifikasi. Silakan cek email untuk link verifikasi.
   ```

---

### Step 5: Test Resend Verification Email

1. **Register** → masuk ke halaman "Verify Email"
2. **Jangan klik link** di email pertama
3. **Klik tombol** "Kirim Ulang Email Verifikasi" di halaman
4. **Cek email** → Email baru terkirim!
5. **Test rate limiting:** Klik tombol berkali-kali (max 6x per menit)

---

## 🔒 Testing Security Features

### 1. Test Signed URL Security

- Copy link verifikasi dari email
- Ubah parameter `id` atau `hash` di URL
- Akses URL yang diubah → **403 Forbidden** ✅

### 2. Test Role-Based Access

- Login sebagai **buyer**
- Coba akses: http://localhost:8000/seller/dashboard
- Result: **403 Unauthorized** ✅

- Login sebagai **seller**
- Coba akses: http://localhost:8000/buyer/dashboard
- Result: **403 Unauthorized** ✅

### 3. Test Middleware Protection

- **Logout** (guest user)
- Coba akses dashboard langsung:
  - http://localhost:8000/buyer/dashboard
  - http://localhost:8000/seller/dashboard
- Result: Redirect ke **login page** ✅

---

## 📧 Cara Melihat Email

### Mailtrap (Recommended)

1. Login ke https://mailtrap.io
2. Buka inbox yang sudah dibuat
3. Email verification akan muncul di sini
4. Klik "Show HTML" untuk lihat email yang bagus
5. Klik link di email untuk verify

### Gmail

- Email masuk ke inbox Gmail yang dikonfigurasi
- Subject: "Verify Email Address"
- Klik tombol "Verify Email Address"

### Log Driver

1. Buka file: `storage/logs/laravel.log`
2. Scroll ke bawah (email terbaru)
3. Cari link yang seperti ini:
   ```
   http://localhost:8000/email/verify/1/abc123...
   ```
4. Copy paste link tersebut ke browser

---

## 🎨 Fitur UI/UX

### Halaman Register
- ✅ Form responsive & modern (Tailwind CSS)
- ✅ Toggle role: Buyer vs Seller
- ✅ Form seller muncul dinamis (Alpine.js)
- ✅ Password strength indicator
- ✅ Toggle show/hide password
- ✅ Validation real-time
- ✅ File upload untuk KTP (seller)

### Halaman Verify Email
- ✅ Desain clean & modern
- ✅ Icon envelope besar
- ✅ Email user ditampilkan
- ✅ Tombol "Resend Email"
- ✅ Instruksi jelas
- ✅ Toast notification untuk success/error

### Dashboard
- ✅ Navbar dengan info user & role badge
- ✅ Logout button
- ✅ Statistics cards
- ✅ Email verification status
- ✅ Different design untuk buyer vs seller

---

## 🐛 Troubleshooting

### Email tidak terkirim?

```bash
# 1. Clear cache
php artisan config:clear
php artisan cache:clear

# 2. Cek .env file sudah benar
# 3. Cek storage/logs/laravel.log untuk error
# 4. Test koneksi SMTP
php artisan tinker
Mail::raw('Test email', function($msg) {
    $msg->to('test@example.com')->subject('Test');
});
```

### Link verification expired?

- Link valid **60 menit** by default
- User bisa klik "Kirim Ulang" di halaman verify

### Error "Too Many Attempts"?

- Rate limiting aktif: max 6 resend per menit
- Tunggu 1 menit, lalu coba lagi

### Database error?

```bash
# Rollback & migrate ulang
php artisan migrate:fresh
```

---

## 📝 Database Structure

### Tabel `users` sekarang memiliki:

```
- id
- name
- email
- email_verified_at ✅ (untuk tracking verification)
- password
- role (admin/seller/buyer) ✅
- phone ✅
- address ✅
- store_name (seller only) ✅
- store_description (seller only) ✅
- pic_name (seller only) ✅
- pic_phone (seller only) ✅
- pic_address (seller only) ✅
- rt, rw, kelurahan, kecamatan ✅
- kota_kab, provinsi, kode_pos ✅
- no_ktp (seller only) ✅
- file_ktp (seller only) ✅
- avatar ✅
- remember_token
- timestamps
```

---

## 🎯 Next Steps (Optional Improvements)

### 1. Custom Email Template
```bash
php artisan vendor:publish --tag=laravel-notifications
```
Edit: `resources/views/vendor/notifications/email.blade.php`

### 2. Add Email Verification Badge di UI
```blade
@if(auth()->user()->hasVerifiedEmail())
    <span class="badge-verified">✅ Verified</span>
@endif
```

### 3. Reminder Email (jika belum verify dalam 24 jam)
Buat job/command untuk kirim reminder email

### 4. Social Login (Google, Facebook)
Install Laravel Socialite

---

## 📞 Support

Jika ada masalah, cek:
1. `storage/logs/laravel.log` untuk error
2. Browser console untuk error JavaScript
3. Network tab di DevTools untuk melihat request/response

---

## ✨ Kesimpulan

**SEMUA FITUR SUDAH BERFUNGSI! 🎉**

✅ Email verification saat register
✅ Login diblokir jika belum verify
✅ Resend verification email
✅ Role-based dashboard (buyer/seller/admin)
✅ Security dengan signed URL
✅ Rate limiting
✅ Responsive UI dengan Tailwind CSS

**Silakan test sekarang dengan menjalankan server dan mengikuti Step 3!** 🚀
