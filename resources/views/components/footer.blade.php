{{-- Footer Profesional --}}
<footer class="bg-gray-900 text-gray-300">
    {{-- Main Footer --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            {{-- Brand & Description --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center p-1">
                        <img src="{{ asset('assets/logo1.png') }}" alt="CampusMarket" class="w-full h-full object-contain">
                    </div>
                    <span class="text-xl font-bold text-white">CampusMarket</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-4">
                    Platform marketplace terpercaya untuk mahasiswa dan umum. 
                    Temukan produk berkualitas dari penjual terverifikasi di seluruh Indonesia.
                </p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-sky-500 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Jelajahi</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product.search') }}" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Cari Produk
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Kategori
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Promo
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Bantuan --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Bantuan</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('cara-berjualan') }}" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Cara Berjualan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2">
                            <i class="fas fa-chevron-right text-xs text-blue-500"></i>
                            Hubungi Kami
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-blue-500 text-sm"></i>
                        </div>
                        <span class="text-gray-400 text-sm">Jl. Pendidikan No. 123, Jakarta Selatan, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-500 text-sm"></i>
                        </div>
                        <a href="mailto:support@campusmarket.id" class="text-gray-400 hover:text-white text-sm transition-colors">
                            support@campusmarket.id
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-blue-500 text-sm"></i>
                        </div>
                        <a href="tel:+6281234567890" class="text-gray-400 hover:text-white text-sm transition-colors">
                            +62 812-3456-7890
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm text-center md:text-left">
                    © {{ date('Y') }} <span class="text-blue-500 font-semibold">CampusMarket</span>. All rights reserved.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </div>
</footer>