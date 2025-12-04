@extends('layouts.app')

@section('title', $product->name . ' - CampusMarket')

@section('content')
    <section class="max-w-screen-2xl mx-auto w-full px-4 sm:px-6 lg:px-10 xl:px-12 py-10">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-8">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
            <span>›</span>
            <a href="{{ route('product.search', ['category_id' => $product->category_id]) }}" class="hover:text-blue-600">
                {{ $product->category->name }}
            </a>
            <span>›</span>
            <span class="text-gray-900 font-semibold">{{ $product->name }}</span>
        </div>

        <!-- Product Details Grid -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Product Image -->
            <div class="flex items-center justify-center bg-gray-50 rounded-xl p-6">
                <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/500x500/EEF2FF/4F46E5?text=' . urlencode(substr($product->name, 0, 20)) }}"
                    alt="{{ $product->name }}" class="rounded-lg w-full h-auto object-cover"
                    onerror="this.src='https://placehold.co/500x500/EEF2FF/4F46E5?text=No+Image'">
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>

                <!-- Rating -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1 text-yellow-400">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < intval($product->rating ?? 4.5))
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="font-semibold text-gray-900">{{ $product->rating ?? 4.5 }}</span>
                    <span class="text-gray-500">({{ $product->comments->count() }} komentar)</span>
                </div>

                <!-- Pricing -->
                <div class="space-y-2">
                    @if ($product->sale_price)
                        <div class="flex items-baseline gap-3">
                            <span class="text-lg text-gray-400 line-through">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm bg-red-100 text-red-600 px-2 py-1 rounded">
                                {{ round((1 - $product->sale_price / $product->price) * 100) }}% OFF
                            </span>
                        </div>
                        <div class="text-4xl font-bold text-blue-600">Rp
                            {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                    @else
                        <div class="text-4xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    @endif
                </div>

                <!-- Stock Info -->
                <div class="flex items-center gap-2">
                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-1 text-green-600 font-semibold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Stok Tersedia ({{ $product->stock }})
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-red-600 font-semibold">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Store Info -->
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-600 mb-2">Dijual Oleh:</p>
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $product->seller->store_name ?? 'Toko' }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $product->seller->kota_kab ?? '' }} {{ $product->seller->provinsi ?? '' }}
                            </p>
                        </div>
                        <a href="{{ route('product.search', ['store_name' => $product->seller->store_name]) }}"
                            class="text-blue-600 hover:text-blue-500 font-semibold text-sm">
                            Lihat Toko →
                        </a>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button
                        class="flex-1 bg-blue-600 text-white rounded-lg py-3 font-semibold hover:bg-blue-500 transition">
                        Tambah ke Keranjang
                    </button>
                    <button
                        class="px-6 py-3 border border-gray-300 rounded-lg font-semibold hover:border-gray-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-12 space-y-12">
            <!-- Product Reviews Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Rating & Review</h2>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Review Form -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tulis Review Anda</h3>
                    <form action="{{ route('product.review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="space-y-4">
                            <!-- Rating -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-2" x-data="{ rating: 0 }">
                                    <template x-for="i in 5" :key="i">
                                        <button type="button" @click="rating = i; $refs.ratingInput.value = i"
                                            class="text-2xl transition"
                                            :class="i <= rating ? 'text-yellow-400' : 'text-gray-300'">
                                            ★
                                        </button>
                                    </template>
                                    <input type="hidden" name="rating" x-ref="ratingInput" required>
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('visitor_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email (Optional) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email (opsional)</label>
                                <input type="email" name="visitor_email" value="{{ old('visitor_email') }}"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('visitor_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Review (opsional)</label>
                                <textarea name="comment" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-500 transition">
                                Kirim Review
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Display Reviews -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Semua Review ({{ $product->reviews->count() }})</h3>
                    @forelse($product->reviews as $review)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-900">{{ $review->visitor_name }}</span>
                                    <div class="flex text-yellow-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $review->rating)
                                                <span>★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Belum ada review untuk produk ini</p>
                    @endforelse
                </div>
            </div>

            <!-- Product Comments Section -->
            @include('components.product-comments', ['product' => $product])
        </div>
    </section>

    @include('components.quick-view-modal')
@endsection
