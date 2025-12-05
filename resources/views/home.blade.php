@extends('layouts.app')

{{-- ini yg aku ubah --}}

@section('title', 'CampusMarket | Homepage')

@push('head')
    <style>
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endpush

@section('content')
    <section class="max-w-screen-2xl mx-auto w-full px-4 sm:px-6 lg:px-10 xl:px-12 py-10" x-data="{
        current: 0,
        banners: {{ Illuminate\Support\Js::from($banners) }},
        autoplayId: null,
        init() { this.play(); },
        play() {
            this.autoplayId = setInterval(() => {
                this.current = (this.current + 1) % this.banners.length;
            }, 6000);
        },
        go(index) {
            this.current = index;
            clearInterval(this.autoplayId);
            this.play();
        }
    }">
        <div class="relative rounded-3xl overflow-hidden shadow-xl" aria-label="Hero carousel">
            <div class="relative h-72 md:h-96">
                <template x-for="(banner, index) in banners" :key="index">
                    <div 
                        x-show="current === index" 
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-x-full"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-full"
                        class="absolute inset-0"
                    >
                        <img :src="banner.image_url" :alt="banner.title" class="w-full h-full object-cover bg-gray-200"
                            loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
                        <div
                            class="absolute inset-y-0 left-0 flex flex-col justify-center px-8 md:px-12 text-white space-y-3 max-w-lg">
                            <p class="uppercase text-xs tracking-[0.3em] text-white/70">Promo Spesial</p>
                            <h1 class="text-2xl md:text-4xl font-bold" x-text="banner.title"></h1>
                            <p class="text-sm md:text-base text-white/80" x-text="banner.subtitle"></p>
                            <a :href="banner.cta_link"
                                class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-full w-max font-semibold hover:bg-blue-500 transition"
                                x-text="banner.cta_text"></a>
                        </div>
                    </div>
                </template>
            </div>

            <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between px-4">
                <button @click="go((current - 1 + banners.length) % banners.length)"
                    class="bg-white/70 hover:bg-white rounded-full p-2" aria-label="Banner sebelumnya">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7" />
                    </svg>
                </button>
                <button @click="go((current + 1) % banners.length)" class="bg-white/70 hover:bg-white rounded-full p-2"
                    aria-label="Banner selanjutnya">
                    <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                <template x-for="(_, index) in banners" :key="'indicator-' + index">
                    <button @click="go(index)" class="w-3 h-3 rounded-full"
                        :class="current === index ? 'bg-white' : 'bg-white/50'"
                        :aria-label="'Pergi ke banner ' + (index + 1)"></button>
                </template>
            </div>
        </div>

        @include('components.category-carousel', ['categories' => $categories])

        <section id="featured" class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    @if (request()->get('category'))
                        @php
                            $selectedCat = $categories->firstWhere('id', request()->get('category'));
                        @endphp
                        Produk {{ $selectedCat['name'] ?? 'Pilihan' }}
                    @else
                        Produk Unggulan
                    @endif
                </h2>
                @if (request()->get('category'))
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500">Lihat
                        semua</a>
                @endif
            </div>
            @if ($featuredProducts->count() > 0)
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-xl">
                    <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Belum ada produk di kategori ini</p>
                </div>
            @endif
        </section>

        <section
            class="mt-12 bg-gradient-to-r from-blue-50 via-white to-orange-50 rounded-3xl p-6 md:p-10 flex flex-col md:flex-row items-center gap-6">
            <div>
                <p class="text-sm uppercase font-semibold text-blue-600">Promo Flash</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">Cashback hingga 50% untuk pengguna baru</h3>
                <p class="text-gray-600 mt-2">Gunakan kode <span class="font-semibold text-blue-600">CAMPUSNEW</span>
                    sebelum 30 November.</p>
            </div>
            <a href="#"
                class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-500 transition">Klaim
                Sekarang</a>
        </section>

        <section id="recommended" class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    @if (request()->get('category'))
                        @php
                            $selectedCat = $categories->firstWhere('id', request()->get('category'));
                        @endphp
                        Semua Produk {{ $selectedCat['name'] ?? '' }}
                    @else
                        Rekomendasi Untukmu
                    @endif
                </h2>
                <div class="text-sm text-gray-500">Total {{ number_format($products->total()) }} produk</div>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12 bg-gray-50 rounded-xl">
                        <i class="fas fa-shopping-bag text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">
                            @if (request()->get('category'))
                                Belum ada produk di kategori ini
                            @else
                                Belum ada produk tersedia
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>
            @if ($products->hasPages())
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </section>
    </section>

    @include('components.quick-view-modal')
@endsection
