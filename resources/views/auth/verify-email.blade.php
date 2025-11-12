@extends('layouts.auth')

@section('title', 'Verify Email')
@section('body-class', 'min-h-screen bg-gradient-to-br from-blue-50 to-purple-50')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden">
        
        <div class="p-8">
            {{-- Icon --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-envelope text-4xl text-blue-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi Email</h2>
                <p class="text-gray-600">Terima kasih telah mendaftar!</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Resend Message --}}
            @if (session('message'))
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        <p class="text-blue-700 text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <p class="text-gray-700 mb-4">
                    Kami telah mengirimkan link verifikasi ke email Anda:
                </p>
                <p class="text-blue-600 font-semibold mb-4 break-all">
                    {{ auth()->user()->email }}
                </p>
                <p class="text-gray-600 text-sm">
                    Silakan cek inbox (atau folder spam) Anda dan klik link verifikasi untuk mengaktifkan akun Anda.
                </p>
            </div>

            {{-- Resend Button --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg hover:scale-105 transform transition-all shadow-lg font-semibold mb-4">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            {{-- Instructions --}}
            <div class="space-y-3 mb-6">
                <div class="flex items-start gap-3 text-sm text-gray-600">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Periksa folder inbox email Anda</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-gray-600">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Jika tidak ada, cek folder Spam/Junk</span>
                </div>
                <div class="flex items-start gap-3 text-sm text-gray-600">
                    <i class="fas fa-check text-green-500 mt-1"></i>
                    <span>Klik tombol "Verify Email" di email tersebut</span>
                </div>
            </div>

            {{-- Logout Link --}}
            <div class="text-center pt-4 border-t">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
