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

        <!-- Search Filter Form -->
        <form action="{{ route('product.search') }}" method="GET" class="space-y-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Refine Search</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                    <!-- Product Name Input -->
                    <div>
                        <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Produk
                        </label>
                        <input 
                            type="text" 
                            id="product_name" 
                            name="product_name" 
                            value="{{ $productName }}"
                            placeholder="Cari produk..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Store Name Input -->
                    <div>
                        <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Toko
                        </label>
                        <input 
                            type="text" 
                            id="store_name" 
                            name="store_name" 
                            value="{{ $storeName }}"
                            placeholder="Cari toko..." 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- Category Select -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori
                        </label>
                        <select 
                            id="category_id" 
                            name="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Province Select -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1">
                            Provinsi
                        </label>
                        <select 
                            id="province" 
                            name="province"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $prov)
                                <option value="{{ $prov }}" {{ $province == $prov ? 'selected' : '' }}>
                                    {{ $prov }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City/District Select -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            Kota/Kabupaten
                        </label>
                        <select 
                            id="city" 
                            name="city"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Semua Kota/Kabupaten</option>
                            @foreach ($cities as $cty)
                                <option value="{{ $cty }}" {{ $city == $cty ? 'selected' : '' }}>
                                    {{ $cty }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-4">
                    <button 
                        type="submit" 
                        class="flex-1 md:flex-initial bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-500 transition"
                    >
                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    <a 
                        href="{{ route('home') }}" 
                        class="bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-400 transition"
                    >
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Active Filters Display -->
        @if ($productName || $storeName || $categoryId || $province || $city)
            <div class="mb-6 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700">Filter Aktif:</span>
                @if ($productName)
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                        Produk: {{ $productName }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">Coba ubah filter pencarian Anda atau kembali ke halaman utama.</p>
                <a 
                    href="{{ route('home') }}" 
                    class="inline-flex items-center bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-500 transition"
                >
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
