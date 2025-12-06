@extends('layouts.seller')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-description', 'Download laporan stok produk dalam format PDF')

@section('content')
    <div class="max-w-4xl">
        {{-- Header --}}
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900">Download Laporan Resmi</h2>
            <p class="text-gray-600 mt-1">Pilih jenis laporan yang ingin diunduh dalam format PDF.</p>
        </div>

        {{-- Report Cards --}}
        <div class="grid gap-6">
            {{-- SRS-MartPlace-12 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-boxes-stacked text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Laporan Stok Produk (Urut Stok Menurun)
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Menampilkan produk berdasarkan stok dari yang terbanyak ke yang terkecil.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('seller.reports.stock-desc') }}"
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

            {{-- SRS-MartPlace-13 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-star text-indigo-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Laporan Stok Produk (Urut Rating Menurun)
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Menampilkan produk berdasarkan rating dari yang tertinggi ke yang terendah.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('seller.reports.rating-desc') }}"
                               class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition-colors">
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

            {{-- SRS-MartPlace-14 --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-triangle-exclamation text-rose-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Laporan Barang yang Harus Segera Dipesan (Stok &lt; 2)
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">
                            Menampilkan produk dengan stok kurang dari 2 sebagai stok kritis yang perlu segera dipesan.
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                            <a href="{{ route('seller.reports.low-stock') }}"
                               class="inline-flex items-center gap-2 bg-rose-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-rose-700 transition-colors">
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
                    <p class="mt-1">
                        Laporan akan diunduh dalam format PDF dan menggunakan data stok produk terkini
                        dari tokomu. Pastikan koneksi internet stabil saat mengunduh laporan.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
