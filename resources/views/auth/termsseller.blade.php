@extends('layouts.auth')

@section('title', 'Kebijakan Privasi Penjual')

@section('content')
    {{-- FONT & BACKGROUND SAMA DENGAN LOGIN/REGISTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Rubik', sans-serif;
        }

        body {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background-color: #e7f0ff;
        }

        html, body {
            height: 100%;
            overflow-y: auto !important;
        }

        body {
            display: block !important;
        }

        .background-blur {
            position: fixed;
            inset: 0;
            background: url("{{ asset('assets/bg2.png') }}") no-repeat center center/cover;
            filter: blur(5px);
            z-index: -1;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.35);
            z-index: -1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.7s ease-out;
        }
    </style>

    {{-- BACKGROUND --}}
    <div class="background-blur"></div>
    <div class="overlay"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 fade-in">

        {{-- Breadcrumb --}}
        <header class="mb-6">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('login') }}" class="hover:text-gray-700">Login</a></li>
                    <li aria-hidden="true" class="text-gray-500 font-semibold">/</li>
                    <li><a href="{{ route('register') }}" class="hover:text-gray-700">Registrasi Penjual</a></li>
                    <li aria-hidden="true" class="text-gray-500 font-semibold">/</li>
                    <li class="text-gray-700 font-medium">Kebijakan Privasi</li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
                Kebijakan Privasi Penjual
            </h1>
            <p class="mt-2 text-gray-600 text-sm md:text-base">
                Kami menjaga privasi Anda. Bacalah kebijakan privasi berikut untuk memahami bagaimana data Anda digunakan
                dan dilindungi.
            </p>
        </header>

        {{-- Card --}}
        <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl ring-1 ring-black/5 overflow-hidden">
            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600"></div>

            <div class="px-6 md:px-8 py-8 space-y-6 text-sm md:text-[15px] leading-relaxed text-gray-700">

                {{-- Pendahuluan --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">1. Pendahuluan</h2>
                    <p>
                        Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data
                        pribadi Anda saat menggunakan <span class="font-semibold text-blue-600">CampusMarket</span> sebagai
                        penjual. Dengan mendaftar, Anda setuju untuk mematuhi kebijakan ini.
                    </p>
                </section>

                {{-- Pengumpulan Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">2. Pengumpulan Data Pribadi</h2>
                    <p>
                        Kami mengumpulkan data pribadi yang Anda berikan saat pendaftaran, termasuk namun tidak terbatas
                        pada nama, email, nomor telepon, alamat, serta data identitas seperti foto dan KTP.
                    </p>
                    <p>
                        Data ini digunakan untuk memverifikasi akun Anda, memproses pesanan, dan komunikasi terkait transaksi
                        serta kebijakan internal <span class="font-semibold text-blue-600">CampusMarket</span>.
                    </p>
                </section>

                {{-- Penggunaan Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">3. Penggunaan Data</h2>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Memverifikasi identitas penjual dan PIC untuk keamanan akun.</li>
                        <li>Memproses pesanan dan transaksi pembelian produk.</li>
                        <li>Mengirimkan pemberitahuan terkait aktivitas transaksi atau pembaruan kebijakan.</li>
                        <li>Meningkatkan layanan dan fitur website berdasarkan feedback pengguna.</li>
                    </ul>
                </section>

                {{-- Pembagian Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">4. Pembagian Data</h2>
                    <p>
                        Kami tidak membagikan data pribadi Anda kepada pihak ketiga kecuali:
                    </p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Untuk memenuhi kewajiban hukum atau jika diwajibkan oleh hukum yang berlaku.</li>
                        <li>Dengan pihak yang mendukung pengelolaan platform, seperti layanan pengiriman atau pemrosesan pembayaran.</li>
                    </ul>
                </section>

                {{-- Keamanan Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">5. Keamanan Data</h2>
                    <p>
                        Kami berkomitmen untuk melindungi data pribadi Anda dengan menggunakan teknologi enkripsi dan langkah-langkah
                        keamanan yang sesuai. Namun, kami tidak dapat menjamin keamanan absolut karena tidak ada sistem yang sepenuhnya aman.
                    </p>
                </section>

                {{-- Penyimpanan Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">6. Penyimpanan Data</h2>
                    <p>
                        Data pribadi yang Anda berikan akan disimpan selama diperlukan untuk tujuan penggunaan layanan <span class="font-semibold text-blue-600">CampusMarket</span>, atau sesuai dengan kebijakan hukum yang berlaku.
                    </p>
                    <p>
                        Anda dapat menghubungi kami untuk meminta penghapusan data pribadi Anda jika tidak lagi diperlukan atau jika Anda membatalkan akun.
                    </p>
                </section>

                {{-- Hak Akses & Kontrol Data --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">7. Hak Akses &amp; Kontrol Data</h2>
                    <p>
                        Anda berhak untuk mengakses, memperbarui, atau menghapus data pribadi Anda yang kami simpan. Anda juga dapat memilih untuk menarik persetujuan Anda atas penggunaan data pribadi tersebut.
                    </p>
                </section>

                {{-- Perubahan Kebijakan --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">8. Perubahan Kebijakan Privasi</h2>
                    <p>
                        Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Perubahan tersebut akan diinformasikan melalui website atau media komunikasi lainnya. Anda disarankan untuk memeriksa halaman ini secara berkala untuk mengetahui pembaruan kebijakan privasi.
                    </p>
                </section>

                {{-- Kontak --}}
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">9. Kontak</h2>
                    <p>
                        Jika Anda memiliki pertanyaan terkait kebijakan privasi ini atau pengelolaan data pribadi Anda, silakan hubungi kami melalui fitur kontak di website atau melalui email support@campusmarket.com.
                    </p>
                </section>

                {{-- Tombol kembali --}}
                <div class="pt-4 border-t border-gray-100 mt-6 flex justify-end">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                        <i class="fas fa-arrow-left text-xs"></i>
                        Kembali ke Registrasi
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('components.footer')
@endsection

