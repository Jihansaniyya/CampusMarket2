@extends('layouts.auth')

@section('title', 'Verifikasi Email')

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
            display: flex;
            flex-direction: column;
            background-color: #e7f0ff;
        }

        .background-blur {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
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

        .content-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
    </style>

    {{-- BACKGROUND --}}
    <div class="background-blur"></div>
    <div class="overlay"></div>

    {{-- CONTENT WRAPPER --}}
    <div class="content-wrapper">
        <div class="relative z-10 w-full max-w-lg mx-auto px-4 sm:px-6">
            <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl ring-1 ring-black/5 overflow-hidden">
                {{-- Top Border Accent --}}
                <div class="h-1 bg-linear-to-r from-blue-600 via-blue-500 to-blue-600"></div>

                <div class="p-8 sm:p-10">
                    {{-- Icon Email --}}
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-400/20 blur-2xl rounded-full"></div>
                            <div class="relative bg-blue-100 rounded-full p-5 shadow-md">
                                <i class="fas fa-envelope text-blue-600 text-4xl"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <h1 class="text-3xl font-bold text-center text-gray-900 mb-2">
                        Verifikasi Email
                    </h1>
                    <p class="text-center text-gray-600 mb-6">
                        Terima kasih telah mendaftar!
                    </p>

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5"></i>
                                <p class="text-emerald-800 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Resend Message --}}
                    @if (session('message'))
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                                <p class="text-blue-800 text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Email Info Box --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 mb-6">
                        <p class="text-gray-700 text-sm mb-3">
                            Kami telah mengirimkan link verifikasi ke email:
                        </p>
                        <p class="text-blue-600 font-semibold text-lg mb-3 break-all">
                            {{ auth()->user()->email }}
                        </p>
                        <p class="text-gray-600 text-sm">
                            Silakan cek inbox atau folder spam Anda dan klik link verifikasi untuk mengaktifkan akun.
                        </p>
                    </div>

                    {{-- Resend Button --}}
                    <form method="POST" action="{{ route('verification.send') }}" class="mb-6">
                        @csrf
                        <button type="submit"
                            class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    {{-- Instructions --}}
                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Periksa folder inbox email Anda</span>
                        </div>
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Jika tidak ada, cek folder Spam/Junk</span>
                        </div>
                        <div class="flex items-start gap-3 text-sm text-gray-600">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span>Klik tombol "Verify Email" di email tersebut</span>
                        </div>
                    </div>

                    {{-- Logout Button --}}
                    <div class="text-center pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-gray-600 hover:text-gray-900 text-sm font-medium transition-colors">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="relative z-10">
        @include('components.footer')
    </div>
@endsection
