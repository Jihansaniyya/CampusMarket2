@extends('layouts.seller')

@section('title', 'Laporan Seller')
@section('page-title', 'Laporan Penjual')
@section('page-description')

@endsection

@section('content')
<div class="space-y-8">

    {{-- INTRO --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Ringkasan Laporan</h2>
    </div>

    {{-- CARDS LAPORAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- SRS-MartPlace-12 --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-2">
                Laporan Stok Produk (Urut Stok Menurun)
            </h3>
            <p class="text-sm text-gray-600 mb-4 flex-1">
                Menampilkan produk berdasarkan stok dari yang terbanyak ke yang terkecil.
            </p>
            <form action="{{ route('seller.reports.stock-desc') }}" method="GET">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-file-pdf"></i>
                    Download Laporan PDF
                </button>
            </form>
        </div>

        {{-- SRS-MartPlace-13 --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-2">
                Laporan Stok Produk (Urut Rating Menurun)
            </h3>
            <p class="text-sm text-gray-600 mb-4 flex-1">
                Menampilkan produk berdasarkan rating dari yang tertinggi ke yang terendah.
            </p>
            
            <form action="{{ route('seller.reports.rating-desc') }}" method="GET">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                    <i class="fas fa-file-pdf"></i>
                    Download Laporan PDF
                </button>
            </form>
        </div>

        {{-- SRS-MartPlace-14 --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-2">
                Laporan Barang yang Harus Segera Dipesan (Stok &lt; 2)
            </h3>
            <p class="text-sm text-gray-600 mb-4 flex-1">
                Menampilkan produk dengan stok kurang dari 2 sebagai stok kritis.
            </p>
            
            <form action="{{ route('seller.reports.low-stock') }}" method="GET">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-rose-600 text-white text-sm font-semibold hover:bg-rose-700 transition">
                    <i class="fas fa-file-pdf"></i>
                    Download Laporan PDF
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
