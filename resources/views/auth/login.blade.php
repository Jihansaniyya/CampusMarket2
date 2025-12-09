@extends('layouts.auth')

@section('title', 'Login')


@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Rubik', sans-serif;
        }

        /* Background blur */
        .background-blur {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('assets/bg2.png') }}") no-repeat center center/cover;
            filter: blur(5px);
            z-index: -2;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.35);
            z-index: -1;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.7s ease-out;
        }
    </style>

    <!-- Background -->
    <div class="background-blur"></div>
    <div class="overlay"></div>

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        {{-- Logo --}}
        <div class="flex justify-center fade-in">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/logo2.png') }}" alt="CampusMarket Logo"
                    class="h-36 md:h-44 lg:h-52 object-contain cursor-pointer hover:opacity-80 transition-opacity">
            </a>
        </div>

        <!-- Login Card -->
        <div class="max-w-md w-full mx-auto bg-white/90 backdrop-blur-md px-8 pt-6 pb-8 shadow-2xl rounded-2xl fade-in">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Selamat Datang Kembali!</h1>
                <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan ke CampusMarket</p>
            </div>

            <!-- Error / Success Alert -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Masukkan email kamu" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="text" id="password" name="password" autocomplete="current-password"
                            class="w-full pl-10 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Masukkan password" required style="-webkit-text-security: disc;">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <i id="toggle-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>

    @include('components.footer')

@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');
            if (!passwordInput) return;

            const isHidden = !passwordInput.style.webkitTextSecurity || passwordInput.style.webkitTextSecurity === 'disc';

            if (isHidden) {
                passwordInput.style.webkitTextSecurity = 'none';
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            } else {
                passwordInput.style.webkitTextSecurity = 'disc';
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        }
    </script>
@endpush
