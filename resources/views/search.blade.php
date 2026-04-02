@extends('layouts.app')

@section('title', 'Hasil Pencarian Produk - CampusMarket')

@section('content')
    <section class="max-w-screen-2xl mx-auto w-full px-4 sm:px-6 lg:px-10 xl:px-12 py-10">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Hasil Pencarian Produk</h1>
            <p class="text-gray-600">
                @if ($products->total() > 0)
                    Menampilkan <span class="font-semibold">{{ $products->count() }}</span> dari
                    <span class="font-semibold">{{ $products->total() }}</span> produk
                @else
                    Tidak ada produk yang ditemukan
                @endif
            </p>
        </div>

        <!-- Active Filters Display -->
        @if ($productName || $storeName || $categoryId || $province || $city)
            <div class="mb-6 flex flex-wrap gap-2">
                @if ($productName)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Pencarian: {{ $productName }}
                    </span>
                @endif
                @if ($storeName)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Toko: {{ $storeName }}
                    </span>
                @endif
                @if ($categoryId)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Kategori: {{ $categories->find($categoryId)?->name }}
                    </span>
                @endif
                @if ($province)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Provinsi: {{ $province }}
                    </span>
                @endif
                @if ($city)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Kota: {{ $city }}
                    </span>
                @endif
            </div>
        @endif

        <!-- Product Grid -->
        @if ($products->count() > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">Coba ubah filter pencarian Anda atau kembali ke halaman utama.</p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </section>

    @include('components.quick-view-modal')
@endsection
