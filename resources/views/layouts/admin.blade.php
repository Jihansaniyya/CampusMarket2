<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - CampusMarket</title>

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
            color: white;
        }

        .sidebar-active i {
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl z-50">
            {{-- Logo --}}
            <div
                class="h-20 flex items-center justify-center border-b border-gray-200 bg-linear-to-r from-blue-600 to-blue-700">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-shopping-cart text-blue-600 text-lg"></i>
                    </div>
                    <div class="text-white">
                        <p class="text-lg font-bold leading-none">CampusMarket</p>
                        <p class="text-xs text-blue-100">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="p-4 space-y-2 overflow-y-auto" style="height: calc(100vh - 180px);">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'sidebar-active shadow-lg' : 'text-gray-700 hover:bg-blue-50' }}">
                    <i
                        class="fas fa-home w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Persetujuan Penjual --}}
                <a href="{{ route('admin.sellers.approval.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sellers.approval.*') ? 'sidebar-active shadow-lg' : 'text-gray-700 hover:bg-blue-50' }}">
                    <i
                        class="fas fa-user-check w-5 {{ request()->routeIs('admin.sellers.approval.*') ? 'text-white' : 'text-blue-600' }}"></i>
                    <span class="font-medium">Persetujuan Penjual</span>
                    @php
                        $pendingCount = \App\Models\User::where('role', 'seller')
                            ->where('approval_status', 'pending')
                            ->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>


                {{-- Divider --}}
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Lainnya</p>
                </div>

                {{-- Laporan --}}
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200">
                    <i class="fas fa-chart-line w-5 text-blue-600"></i>
                    <span class="font-medium">Laporan</span>
                </a>

                {{-- Pengaturan --}}
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200">
                    <i class="fas fa-cog w-5 text-blue-600"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </nav>

            {{-- User Profile Card --}}
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span
                            class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-rose-600 transition-colors"
                            title="Logout">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content Area --}}
        <div class="flex-1 ml-64">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600">@yield('page-description', 'Selamat datang di CampusMarket Admin')</p>
                    </div>

                    <div class="flex items-center gap-4">
                        {{-- Notifications --}}
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            @if ($pendingCount > 0)
                                <span
                                    class="absolute top-0 right-0 w-5 h-5 bg-rose-500 text-white text-xs flex items-center justify-center rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </button>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="px-6 py-4 border-t border-gray-200 bg-white">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <p>&copy; 2025 CampusMarket. All rights reserved.</p>
                    <p>Made with <i class="fas fa-heart text-rose-500"></i> by CampusMarket Team</p>
                </div>
            </footer>
        </div>
    </div>

    {{-- Scripts --}}
    @stack('scripts')
</body>

</html>
