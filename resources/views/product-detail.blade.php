@extends('layouts.app')

@section('title', $product->name . ' - CampusMarket')

@section('content')
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-800 transition-colors">Beranda</a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('product.search', ['category_id' => $product->category_id]) }}"
                class="hover:text-gray-800 transition-colors">
                {{ $product->category->name }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-800">{{ Str::limit($product->name, 30) }}</span>
        </nav>

        <!-- Main Product Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid lg:grid-cols-5 gap-0">
                <!-- Product Image -->
                <div class="lg:col-span-2 p-6 lg:p-8">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-50">
                        @php
                            $imageUrl =
                                'https://placehold.co/500x500/f8fafc/64748b?text=' .
                                urlencode(substr($product->name, 0, 15));
                            if ($product->thumbnail) {
                                $imageUrl = str_starts_with($product->thumbnail, 'http')
                                    ? $product->thumbnail
                                    : asset('storage/' . $product->thumbnail);
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                            onerror="this.src='https://placehold.co/500x500/f8fafc/64748b?text=No+Image'">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="lg:col-span-3 p-6 lg:p-8 lg:border-l border-gray-100">
                    <!-- Category Badge -->
                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full mb-3">
                        {{ $product->category->name }}
                    </span>

                    <!-- Product Name -->
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Stats -->
                    <div class="flex flex-wrap items-center gap-4 mb-5 text-sm">
                        <div class="flex items-center gap-1.5">
                            <div class="flex text-amber-400">
                                @php
                                    $rating = $product->reviews->avg('rating') ?? 0;
                                    $rating = round($rating, 1);
                                @endphp
                                @if ($rating > 0)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($rating))
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                                            </svg>
                                        @endif
                                    @endfor
                                @else
                                    <span class="text-gray-400 text-xs">Belum ada rating</span>
                                @endif
                            </div>
                            @if ($rating > 0)
                                <span class="font-semibold text-gray-800">{{ number_format($rating, 1) }}</span>
                            @endif
                        </div>
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-500">{{ $product->reviews->count() }} ulasan</span>
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-500">{{ $product->comments->count() }} komentar</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        @if ($product->sale_price)
                            <div class="flex items-baseline gap-3 mb-1">
                                <span class="text-3xl font-bold text-gray-900">
                                    Rp {{ number_format($product->sale_price, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-400 line-through">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <span class="inline-block px-2 py-0.5 bg-red-50 text-red-600 text-xs font-semibold rounded">
                                Hemat {{ round((1 - $product->sale_price / $product->price) * 100) }}%
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    @if ($product->description)
                        <div class="mb-6">
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Stock Status -->
                    <div class="flex items-center gap-2 mb-6 pb-6 border-b border-gray-100">
                        @if ($product->stock > 0)
                            <span
                                class="inline-flex items-center gap-1.5 text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Stok tersedia ({{ $product->stock }})
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 text-sm text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Stok habis
                            </span>
                        @endif
                    </div>

                    <!-- Seller Info -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if ($product->seller->avatar)
                                    <img src="{{ asset('storage/' . $product->seller->avatar) }}"
                                        alt="{{ $product->seller->store_name }}"
                                        class="w-11 h-11 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-11 h-11 bg-linear-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->seller->store_name ?? 'Toko' }}</p>
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $product->seller->kota_kab ?? 'Indonesia' }}{{ $product->seller->provinsi ? ', ' . $product->seller->provinsi : '' }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('product.search', ['store_name' => $product->seller->store_name]) }}"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Kunjungi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Ulasan Pembeli</h2>
                <span class="text-sm text-gray-500">{{ $product->reviews->count() }} ulasan</span>
            </div>

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Review Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-100 p-5 sticky top-24">
                        <h3 class="font-semibold text-gray-900 mb-4">Tulis Ulasan</h3>
                        <form action="{{ route('product.review.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Rating -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Rating</label>
                                <div class="flex gap-1" x-data="{ rating: 0, hover: 0 }">
                                    <template x-for="i in 5" :key="i">
                                        <button type="button" @click="rating = i; $refs.ratingInput.value = i"
                                            @mouseenter="hover = i" @mouseleave="hover = 0"
                                            class="text-2xl transition-transform hover:scale-110"
                                            :class="i <= (hover || rating) ? 'text-amber-400' : 'text-gray-200'">
                                            ★
                                        </button>
                                    </template>
                                    <input type="hidden" name="rating" x-ref="ratingInput" required>
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-1.5">Nama</label>
                                <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" required
                                    placeholder="Nama kamu"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all outline-none">
                                @error('visitor_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-1.5">Email <span
                                        class="text-gray-400">(opsional)</span></label>
                                <input type="email" name="visitor_email" value="{{ old('visitor_email') }}"
                                    placeholder="email@contoh.com"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all outline-none">
                                @error('visitor_email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div x-data="{ provinces: [], loading: true }" x-init="fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                                .then(res => res.json())
                                .then(data => {
                                    provinces = data;
                                    loading = false;
                                })
                                .catch(() => loading = false)">
                                <label class="block text-sm text-gray-600 mb-1.5">Provinsi</label>
                                <select name="province" required
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all outline-none bg-white">
                                    <option value="">Pilih provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.id">
                                        <option :value="prov.name" x-text="prov.name"></option>
                                    </template>
                                </select>
                                @error('province')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-1.5">Ulasan <span
                                        class="text-gray-400">(opsional)</span></label>
                                <textarea name="comment" rows="3" placeholder="Bagikan pengalamanmu dengan produk ini..."
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all outline-none resize-none">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700 transition">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Reviews List -->
                <div class="lg:col-span-2 space-y-4">
                    @forelse($product->reviews as $review)
                        <div class="bg-white rounded-xl border border-gray-100 p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 bg-linear-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-gray-600 font-medium text-sm">
                                            {{ strtoupper(substr($review->visitor_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $review->visitor_name }}</p>
                                        <div class="flex items-center gap-2">
                                            <div class="flex text-amber-400 text-xs">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <span
                                                        class="{{ $i < $review->rating ? '' : 'text-gray-200' }}">★</span>
                                                @endfor
                                            </div>
                                            @if ($review->province)
                                                <span class="text-gray-300">•</span>
                                                <span class="text-xs text-gray-400">{{ $review->province }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada ulasan</p>
                            <p class="text-gray-400 text-xs mt-1">Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    @include('components.quick-view-modal')
@endsection
