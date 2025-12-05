@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-description', 'Download laporan resmi dalam format PDF')

@section('content')
    <div class="max-w-4xl">
        {{-- Header --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900">Download Laporan Resmi</h2>
            <p class="text-gray-600 mt-1">Pilih jenis laporan yang ingin diunduh dalam format PDF</p>
        </div>

        {{-- Report Cards --}}
        <div class="grid gap-6">
            {{-- Laporan Penjual Aktif/Tidak Aktif --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-check text-emerald-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Laporan Penjual Aktif & Tidak Aktif</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Daftar lengkap penjual berdasarkan status keaktifan (aktif/tidak aktif), 
                            termasuk informasi toko, kontak, dan status approval.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('admin.reports.sellers.status') }}" 
                               class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-emerald-700 transition-colors">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </a>
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-file-pdf mr-1"></i> Format PDF
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Laporan Penjual per Provinsi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Laporan Penjual per Provinsi</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Sebaran penjual berdasarkan provinsi di Indonesia, 
                            menampilkan jumlah toko dan detail penjual di setiap provinsi.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('admin.reports.sellers.provinces') }}" 
                               class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-blue-700 transition-colors">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </a>
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-file-pdf mr-1"></i> Format PDF
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Laporan Produk & Rating --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-star text-amber-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Laporan Produk & Rating</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Daftar produk beserta rating dari pembeli, 
                            diurutkan berdasarkan rating tertinggi dengan informasi toko dan harga.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('admin.reports.products.ratings') }}" 
                               class="inline-flex items-center gap-2 bg-amber-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-amber-700 transition-colors">
                                <i class="fas fa-download"></i>
                                Download PDF
                            </a>
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-file-pdf mr-1"></i> Format PDF
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-medium">Informasi</p>
                    <p class="mt-1">Laporan akan diunduh dalam format PDF dan berisi data terkini dari sistem. 
                    Pastikan koneksi internet stabil saat mengunduh laporan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
