@extends('layouts.app')

@section('title', 'FAQ - CampusMarket')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-blue-100">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- FAQ Categories --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium">Semua</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-100 transition">Akun</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-100 transition">Penjual</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-100 transition">Pembeli</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-full text-sm font-medium hover:bg-gray-100 transition">Pembayaran</button>
        </div>

        {{-- FAQ List --}}
        <div class="space-y-4" x-data="{ openFaq: null }">
            {{-- FAQ 1 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 1 ? null : 1" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Bagaimana cara mendaftar sebagai penjual?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 1 }"></i>
                </button>
                <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Untuk mendaftar sebagai penjual, klik tombol "Daftar" di halaman utama, lalu pilih opsi "Daftar sebagai Penjual". 
                        Isi formulir dengan lengkap termasuk data toko, alamat, dan upload foto KTP untuk verifikasi. 
                        Setelah itu, tunggu persetujuan dari admin dalam 1-3 hari kerja.
                    </p>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 2 ? null : 2" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Berapa lama proses verifikasi akun penjual?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 2 }"></i>
                </button>
                <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Proses verifikasi akun penjual membutuhkan waktu 1-3 hari kerja. Tim kami akan memeriksa kelengkapan data 
                        dan dokumen yang Anda upload. Anda akan menerima notifikasi email ketika akun sudah disetujui atau jika 
                        ada data yang perlu dilengkapi.
                    </p>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 3 ? null : 3" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Apakah ada biaya untuk berjualan di CampusMarket?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 3 }"></i>
                </button>
                <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Saat ini, CampusMarket tidak memungut biaya pendaftaran maupun biaya bulanan untuk penjual. 
                        Anda bisa mulai berjualan secara gratis! Kami mungkin akan menerapkan biaya transaksi di masa depan, 
                        tetapi akan diinformasikan terlebih dahulu.
                    </p>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 4 ? null : 4" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Bagaimana cara menambahkan produk?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 4 }"></i>
                </button>
                <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Setelah akun penjual Anda disetujui, login ke Dashboard Seller. Klik menu "Produk" lalu "Tambah Produk". 
                        Isi informasi produk seperti nama, deskripsi, harga, stok, kategori, dan upload foto produk. 
                        Klik "Simpan" dan produk Anda akan langsung tampil di marketplace.
                    </p>
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 5 ? null : 5" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Bagaimana cara menghubungi penjual?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 5 }"></i>
                </button>
                <div x-show="openFaq === 5" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Anda bisa menghubungi penjual melalui fitur komentar/pertanyaan di halaman detail produk. 
                        Tulis pertanyaan Anda dan penjual akan menerima notifikasi. Beberapa penjual juga mencantumkan 
                        nomor WhatsApp di profil toko mereka.
                    </p>
                </div>
            </div>

            {{-- FAQ 6 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 6 ? null : 6" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Bagaimana sistem pembayaran di CampusMarket?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 6 }"></i>
                </button>
                <div x-show="openFaq === 6" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Saat ini pembayaran dilakukan langsung antara pembeli dan penjual (COD atau transfer). 
                        Kami sedang mengembangkan sistem pembayaran terintegrasi yang akan hadir dalam waktu dekat 
                        untuk memberikan keamanan transaksi yang lebih baik.
                    </p>
                </div>
            </div>

            {{-- FAQ 7 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 7 ? null : 7" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Bagaimana cara memberikan rating dan review?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 7 }"></i>
                </button>
                <div x-show="openFaq === 7" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Anda bisa memberikan rating dan review di halaman detail produk. Scroll ke bagian "Ulasan" 
                        dan klik tombol "Tulis Ulasan". Berikan rating bintang (1-5) dan tulis pengalaman Anda 
                        dengan produk tersebut. Review Anda akan membantu pembeli lain dalam mengambil keputusan.
                    </p>
                </div>
            </div>

            {{-- FAQ 8 --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button @click="openFaq = openFaq === 8 ? null : 8" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-900">Apa yang harus dilakukan jika lupa password?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{ 'rotate-180': openFaq === 8 }"></i>
                </button>
                <div x-show="openFaq === 8" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">
                        Klik "Lupa Password" di halaman login. Masukkan email yang terdaftar dan kami akan mengirimkan 
                        link untuk reset password. Klik link tersebut dan buat password baru. Jika tidak menerima email, 
                        cek folder Spam atau hubungi tim support kami.
                    </p>
                </div>
            </div>
        </div>

        {{-- Contact CTA --}}
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-3">Masih punya pertanyaan?</h2>
            <p class="text-blue-100 mb-6">Tim support kami siap membantu Anda</p>
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-colors">
                <i class="fas fa-envelope"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
@endsection
