<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/logo1.png') }}">
    <title>@yield('title', 'Seller Dashboard') - CampusMarket</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Rubik', sans-serif;
        }

        .sidebar-active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white !important;
        }

        .sidebar-active i {
            color: white !important;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-50">

            {{-- LOGO --}}
            <div
                class="h-20 flex items-center justify-center border-b border-gray-200 bg-linear-to-r from-blue-600 to-blue-700">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-md p-1">
                        <img src="{{ asset('assets/logo1.png') }}" alt="CampusMarket"
                            class="w-full h-full object-contain">
                    </div>
                    <div class="text-white">
                        <p class="text-lg font-bold leading-none">CampusMarket</p>
                        <p class="text-xs text-blue-100">Seller Panel</p>
                    </div>
                </a>
            </div>

            {{-- MENU --}}
            <nav class="p-4 space-y-2 overflow-y-auto" style="height: calc(100vh - 180px);">

                {{-- Dashboard --}}
                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('seller.dashboard') ? 'sidebar-active shadow-lg' : 'text-gray-700 hover:bg-blue-50' }}">
                    <i
                        class="fas fa-home w-5 {{ request()->routeIs('seller.dashboard') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- UPLOAD PRODUK --}}
                <a href="{{ route('seller.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('seller.products.*') ? 'sidebar-active shadow-lg' : 'text-gray-700 hover:bg-blue-50' }}">
                    <i
                        class="fas fa-box w-5 {{ request()->routeIs('seller.products.*') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Produk</span>
                </a>

                {{-- Rating & Komentar --}}
                <a href="{{ route('seller.ratings.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
    {{ request()->routeIs('seller.ratings.*') || request()->routeIs('seller.comments.*')
        ? 'sidebar-active shadow-lg'
        : 'text-gray-700 hover:bg-blue-50' }}">
                    <i
                        class="fas fa-star w-5 {{ request()->routeIs('seller.ratings.*') || request()->routeIs('seller.comments.*') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Rating & Komentar</span>
                </a>


                {{-- Divider --}}
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</p>
                </div>

                {{-- Laporan --}}
                <a href="{{ route('seller.reports.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200
        {{ request()->routeIs('seller.reports.*') ? 'sidebar-active shadow-lg' : '' }}">
                    <i
                        class="fas fa-chart-line w-5 {{ request()->routeIs('seller.reports.*') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Laporan</span>
                </a>

                {{-- Profile --}}
                <a href="{{ route('seller.profile') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200
        {{ request()->routeIs('seller.profile') ? 'sidebar-active shadow-lg' : '' }}">
                    <i
                        class="fas fa-user-circle w-5 {{ request()->routeIs('seller.profile') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Profile</span>
                </a>



            </nav>

            {{-- USER PROFILE --}}
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr(Auth::user()->store_name ?? Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-600 font-medium truncate">
                            {{ Auth::user()->store_name ?? 'Seller' }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-rose-600 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- MAIN CONTENT AREA (WAJIB ADA) --}}
        <div class="flex-1 ml-64">

            {{-- TOP BAR --}}
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            @yield('page-title', 'Dashboard Penjual')
                        </h1>
                        <p class="text-sm text-gray-600">
                            @yield('page-description', 'Selamat datang di panel penjual')
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <div class="mt-16">
                @include('components.footer')
            </div>

        </div>

    </div>

    {{-- Scripts --}}
    @stack('scripts')
</body>

</html>
