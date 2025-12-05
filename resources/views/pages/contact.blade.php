@extends('layouts.app')

@section('title', 'Hubungi Kami - CampusMarket')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-xl text-blue-100">Kami siap membantu Anda kapan saja</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Contact Info --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Email --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600 text-sm mb-2">Kirim email untuk pertanyaan umum</p>
                            <a href="mailto:support@campusmarket.id" class="text-blue-600 font-medium hover:underline">
                                support@campusmarket.id
                            </a>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">WhatsApp</h3>
                            <p class="text-gray-600 text-sm mb-2">Chat langsung dengan tim kami</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-green-600 font-medium hover:underline">
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600 text-sm mb-2">Senin - Jumat, 09:00 - 17:00 WIB</p>
                            <a href="tel:+6281234567890" class="text-purple-600 font-medium hover:underline">
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Alamat</h3>
                            <p class="text-gray-600 text-sm">
                                Jl. Pendidikan No. 123<br>
                                Jakarta Selatan, 12345<br>
                                Indonesia
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Social Media --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-blue-100 hover:bg-blue-600 hover:text-white text-blue-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-100 hover:bg-pink-600 hover:text-white text-pink-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-sky-100 hover:bg-sky-500 hover:text-white text-sky-500 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-100 hover:bg-red-600 hover:text-white text-red-600 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-600 mb-6">Isi formulir di bawah ini dan kami akan segera merespons</p>

                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                       placeholder="Masukkan nama Anda">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                       placeholder="nama@email.com">
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subjek <span class="text-red-500">*</span>
                            </label>
                            <select id="subject" name="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Pilih subjek</option>
                                <option value="general">Pertanyaan Umum</option>
                                <option value="seller">Pertanyaan Penjual</option>
                                <option value="buyer">Pertanyaan Pembeli</option>
                                <option value="technical">Masalah Teknis</option>
                                <option value="feedback">Saran & Masukan</option>
                                <option value="partnership">Kerjasama</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        {{-- Phone (Optional) --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon <span class="text-gray-400">(opsional)</span>
                            </label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="08xx-xxxx-xxxx">
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"
                                      placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                <span class="text-red-500">*</span> Wajib diisi
                            </p>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Response Time Info --}}
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium">Waktu Respons</p>
                            <p class="mt-1">Kami akan merespons pesan Anda dalam waktu 1x24 jam pada hari kerja. 
                            Untuk pertanyaan mendesak, silakan hubungi kami via WhatsApp.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
