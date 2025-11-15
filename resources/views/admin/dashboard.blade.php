@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')
@section('page-description')
    Selamat datang, {{ Auth::user()->name }}! 👋
@endsection

@section('content')
    <div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Pending Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-amber-400 to-orange-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-3xl"></i>
                        </div>
                        @if ($pendingSellersCount > 0)
                            <span class="px-3 py-1 bg-white/30 backdrop-blur-sm rounded-full text-xs font-bold">Perlu
                                Aksi</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Menunggu Persetujuan</p>
                    <p class="text-4xl font-bold mb-4">{{ $pendingSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Approved Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-emerald-400 to-teal-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Penjual Disetujui</p>
                    <p class="text-4xl font-bold mb-4">{{ $approvedSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Rejected Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-rose-400 to-pink-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-times-circle text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Penjual Ditolak</p>
                    <p class="text-4xl font-bold mb-4">{{ $rejectedSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Total Users --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-blue-500 to-indigo-600"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Total Users</p>
                    <p class="text-4xl font-bold mb-4">{{ $totalUsers }}</p>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.sellers.approval.index') }}"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-user-check text-blue-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Persetujuan Penjual
                        </p>
                        <p class="text-sm text-gray-600">Kelola pendaftaran penjual</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-blue-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl border-2 border-emerald-100 hover:border-emerald-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-users-cog text-emerald-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">Kelola User</p>
                        <p class="text-sm text-gray-600">Manajemen semua user</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-emerald-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>

                <a href="#"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl border-2 border-violet-100 hover:border-violet-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-chart-line text-violet-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-violet-600 transition-colors">Laporan</p>
                        <p class="text-sm text-gray-600">Statistik dan analytics</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-violet-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h2>
            </div>
            <div class="text-center py-12">
                <div
                    class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">Fitur aktivitas akan segera hadir</p>
                <p class="text-sm text-gray-400 mt-1">Pantau semua aktivitas admin dan user di sini</p>
            </div>
        </div>
    </div>
@endsection
