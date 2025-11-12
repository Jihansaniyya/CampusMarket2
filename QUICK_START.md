# 🚀 Quick Start - Email Verification

## Setup Cepat (5 Menit)

### 1. Update .env untuk Email (pilih salah satu):

**Mailtrap (Testing - Gratis):**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=YOUR_MAILTRAP_USERNAME
MAIL_PASSWORD=YOUR_MAILTRAP_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

**Log Driver (Tanpa Email Real):**
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@campusmarket.com"
MAIL_FROM_NAME="CampusMarket"
```

### 2. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Jalankan Server
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### 4. Test!
1. Buka: http://localhost:8000/register
2. Register dengan role **buyer** atau **seller**
3. Cek email (Mailtrap inbox atau `storage/logs/laravel.log`)
4. Klik link verifikasi
5. Login → Dashboard! ✅

---

## Fitur yang Sudah Ada

✅ **Email verification** saat register
✅ **Login diblokir** jika belum verify  
✅ **Resend email** verification  
✅ **3 Role**: Admin, Seller, Buyer  
✅ **Role-based dashboard**  
✅ **Seller form** dengan 14+ field tambahan  
✅ **Security**: Signed URL, rate limiting  
✅ **UI/UX**: Tailwind CSS, responsive, modern  

---

## Perbedaan Role

### Buyer
- Form register: basic (name, email, phone, password)
- Dashboard: orders, wishlist, cart

### Seller
- Form register: extended (+ store info, PIC, KTP, alamat lengkap)
- Dashboard: products, orders, revenue, reports

### Admin
- Manage semua users, products, orders
- Analytics & reports

---

## Troubleshooting 1 Menit

**Email tidak terkirim?**
→ Gunakan `MAIL_MAILER=log`, cek `storage/logs/laravel.log`

**Login gagal terus?**
→ Pastikan sudah klik link verifikasi di email

**Error 403?**
→ Role salah, pastikan login dengan role yang sesuai

**Link expired?**
→ Klik tombol "Kirim Ulang Email Verifikasi"

---

## Lihat File Lengkap

- 📖 **Setup Email**: `EMAIL_VERIFICATION_SETUP.md`
- 🧪 **Panduan Testing**: `TESTING_GUIDE.md`

---

**Ready to test? GO! 🚀**
