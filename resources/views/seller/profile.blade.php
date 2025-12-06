@extends('layouts.seller')

@section('title', 'Profile Seller')
@section('page-title', 'Profile Toko')
@section('page-description', 'Informasi lengkap tentang toko dan data penjual')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Store Information Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-blue-600 font-bold text-3xl">
                            {{ strtoupper(substr($seller->store_name ?? $seller->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">{{ $seller->store_name ?? 'Nama Toko Belum Diatur' }}</h2>
                        <p class="text-blue-100 text-sm mt-1">
                            <i class="fas fa-store mr-2"></i>Seller Account
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Personal Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3">
                            <i class="fas fa-user text-blue-600 mr-2"></i>Informasi Pribadi
                        </h3>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                                    <p class="font-medium text-gray-900">{{ $seller->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-envelope text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Email</p>
                                    <p class="font-medium text-gray-900">{{ $seller->email }}</p>
                                    @if ($seller->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-xs text-green-600 mt-1">
                                            <i class="fas fa-check-circle"></i>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs text-orange-600 mt-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            Belum Terverifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-phone text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Nomor Telepon</p>
                                    <p class="font-medium text-gray-900">{{ $seller->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Store & Location Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3">
                            <i class="fas fa-store text-blue-600 mr-2"></i>Informasi Toko & Lokasi
                        </h3>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-shop text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Nama Toko</p>
                                    <p class="font-medium text-gray-900">{{ $seller->store_name ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-map-marked-alt text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Provinsi</p>
                                    <p class="font-medium text-gray-900">{{ $seller->provinsi ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-city text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Kota/Kabupaten</p>
                                    <p class="font-medium text-gray-900">{{ $seller->kota_kab ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fas fa-home text-blue-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 mb-1">Alamat Lengkap</p>
                                    <p class="font-medium text-gray-900">{{ $seller->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Account Status Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-shield-check text-blue-600 mr-2"></i>Status Akun
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Role Status --}}
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-700 font-medium">Role</span>
                        <i class="fas fa-user-tag text-blue-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-blue-700 capitalize">{{ $seller->role }}</p>
                </div>

                {{-- Approval Status --}}
                @if ($seller->approval_status === 'approved')
                    <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-green-700 font-medium">Status Persetujuan</span>
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-green-700">Disetujui</p>
                    </div>
                @elseif($seller->approval_status === 'rejected')
                    <div class="bg-red-50 rounded-xl p-5 border border-red-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-red-700 font-medium">Status Persetujuan</span>
                            <i class="fas fa-times-circle text-red-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-red-700">Ditolak</p>
                    </div>
                @else
                    <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-orange-700 font-medium">Status Persetujuan</span>
                            <i class="fas fa-clock text-orange-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-orange-700">Menunggu</p>
                    </div>
                @endif

                {{-- Join Date --}}
                <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-purple-700 font-medium">Bergabung Sejak</span>
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-purple-700">{{ $seller->created_at->format('d M Y') }}</p>
                </div>

            </div>

            @if ($seller->approval_status === 'rejected' && $seller->rejection_reason)
                <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-5">
                    <div class="flex gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 mt-1"></i>
                        <div>
                            <p class="font-semibold text-red-900 mb-1">Alasan Penolakan</p>
                            <p class="text-red-700 text-sm">{{ $seller->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Quick Stats --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-chart-bar text-blue-600 mr-2"></i>Statistik Toko
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="text-center p-5 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                    <i class="fas fa-box text-blue-600 text-3xl mb-3"></i>
                    <p class="text-3xl font-bold text-blue-700">{{ $seller->products()->count() }}</p>
                    <p class="text-sm text-blue-600 mt-1">Total Produk</p>
                </div>

                <div class="text-center p-5 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                    <i class="fas fa-check-circle text-green-600 text-3xl mb-3"></i>
                    <p class="text-3xl font-bold text-green-700">
                        {{ $seller->products()->where('is_active', true)->count() }}</p>
                    <p class="text-sm text-green-600 mt-1">Produk Aktif</p>
                </div>

                <div class="text-center p-5 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl">
                    <i class="fas fa-star text-orange-600 text-3xl mb-3"></i>
                    <p class="text-3xl font-bold text-orange-700">
                        {{ number_format($seller->products()->avg('rating') ?? 0, 1) }}
                    </p>
                    <p class="text-sm text-orange-600 mt-1">Rating Rata-rata</p>
                </div>

                <div class="text-center p-5 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                    <i class="fas fa-comments text-purple-600 text-3xl mb-3"></i>
                    <p class="text-3xl font-bold text-purple-700">
                        {{ $seller->products()->withCount('reviews')->get()->sum('reviews_count') }}
                    </p>
                    <p class="text-sm text-purple-600 mt-1">Total Review</p>
                </div>

            </div>
        </div>

    </div>
@endsection
