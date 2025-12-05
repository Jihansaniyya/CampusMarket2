@extends('layouts.app')

@section('title', 'Cara Berjualan - CampusMarket')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Cara Berjualan di CampusMarket</h1>
            <p class="text-xl text-blue-100">Mulai bisnis online Anda dengan mudah dan cepat</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Steps --}}
        <div class="space-y-8">
            {{-- Step 1 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-blue-600">1</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Daftar Akun Penjual</h3>
                        <p class="text-gray-600 mb-4">
                            Klik tombol "Daftar" di halaman utama dan pilih opsi "Daftar sebagai Penjual". 
                            Isi formulir pendaftaran dengan data yang lengkap dan valid.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Siapkan foto KTP untuk verifikasi
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Isi nama toko yang unik dan menarik
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Lengkapi alamat toko dengan detail
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-blue-600">2</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Verifikasi Email</h3>
                        <p class="text-gray-600 mb-4">
                            Setelah mendaftar, Anda akan menerima email verifikasi. Klik link yang ada di email 
                            untuk memverifikasi akun Anda.
                        </p>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
                                <p class="text-sm text-amber-800">
                                    Pastikan cek folder Spam jika email tidak masuk ke Inbox.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-blue-600">3</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tunggu Persetujuan Admin</h3>
                        <p class="text-gray-600 mb-4">
                            Tim kami akan memverifikasi data Anda dalam waktu 1-3 hari kerja. 
                            Anda akan menerima notifikasi email ketika akun sudah disetujui.
                        </p>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-gray-500">
                                <i class="fas fa-clock"></i>
                                <span>Proses: 1-3 hari kerja</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl font-bold text-blue-600">4</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tambahkan Produk</h3>
                        <p class="text-gray-600 mb-4">
                            Setelah akun disetujui, login ke Dashboard Seller dan mulai tambahkan produk Anda.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Upload foto produk yang jelas dan menarik
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Tulis deskripsi produk yang lengkap
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Tentukan harga yang kompetitif
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                Pilih kategori yang sesuai
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Step 5 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Mulai Berjualan!</h3>
                        <p class="text-gray-600 mb-4">
                            Produk Anda akan tampil di halaman utama dan bisa ditemukan oleh pembeli. 
                            Kelola pesanan, balas pertanyaan, dan kembangkan bisnis Anda!
                        </p>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-rocket"></i>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tips Section --}}
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tips Sukses Berjualan</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-camera text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Foto Berkualitas</h4>
                        <p class="text-sm text-gray-600">Gunakan pencahayaan yang baik dan tampilkan produk dari berbagai sudut.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-comment-dots text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Respon Cepat</h4>
                        <p class="text-sm text-gray-600">Balas pertanyaan pembeli dengan cepat untuk meningkatkan kepercayaan.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-tags text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Harga Kompetitif</h4>
                        <p class="text-sm text-gray-600">Riset harga pasar dan tawarkan harga yang bersaing.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-star text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Jaga Rating</h4>
                        <p class="text-sm text-gray-600">Berikan pelayanan terbaik untuk mendapat rating positif dari pembeli.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
