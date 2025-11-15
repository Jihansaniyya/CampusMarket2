@extends('layouts.auth')

@section('title', 'Menunggu Persetujuan')

@section('content')
    {{-- FONT & BACKGROUND --}}
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
                <div class="h-1 bg-linear-to-r from-amber-500 via-amber-400 to-amber-500"></div>

                <div class="p-8">
                    {{-- Icon Jam Pasir --}}
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-amber-400/20 blur-2xl rounded-full"></div>
                            <div class="relative bg-amber-100 rounded-full p-5 shadow-md">
                                <i class="fas fa-hourglass-half text-amber-600 text-4xl"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Heading --}}
                    <h1 class="text-3xl font-bold text-center text-gray-900 mb-4">
                        Menunggu Persetujuan
                    </h1>

                    <p class="text-center text-gray-600 mb-8">
                        Pendaftaran Anda sedang ditinjau oleh admin.
                    </p>

                    {{-- Action Button --}}
                    <div class="mb-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                <i class="fas fa-sign-out-alt mr-2"></i>Kembali ke Halaman Login
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
