@props(['product'])

@php
    $productJson = Illuminate\Support\Js::from($product);
@endphp

<article class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition flex flex-col">
    <div class="relative">
        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy"
            class="w-full h-56 object-cover rounded-t-2xl bg-gray-100"
            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'400\'%3E%3Crect width=\'400\' height=\'400\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'Arial\' font-size=\'20\'%3E{{ $product['name'] }}%3C/text%3E%3C/svg%3E';">
        @if (!empty($product['badge']))
            <span
                class="absolute top-4 left-4 bg-orange-400 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">{{ $product['badge'] }}</span>
        @endif
        <button type="button"
            class="absolute top-4 right-4 bg-white/90 backdrop-blur border border-gray-200 rounded-full p-2 text-gray-700 hover:text-blue-600"
            @click="$store.quickView.openModal({{ $productJson }})" aria-label="Quick view {{ $product['name'] }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
            </svg>
        </button>
    </div>
    <div class="p-5 flex flex-col gap-3 flex-1">
        <div>
            <h3 class="text-base font-semibold text-gray-900 line-clamp-2">{{ $product['name'] }}</h3>
            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $product['short_description'] }}</p>
        </div>
        <div class="flex items-center gap-1 text-sm text-amber-500">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
            </svg>
            <span class="font-semibold">{{ number_format($product['rating'], 1) }}</span>
            <span class="text-gray-400">({{ number_format($product['reviews_count']) }})</span>
        </div>
        <div class="mt-auto">
            <div class="flex items-baseline gap-2">
                @if ($product['sale_price'])
                    <span class="text-sm text-gray-400 line-through">Rp
                        {{ number_format($product['price'], 0, ',', '.') }}</span>
                    <span class="text-xl font-semibold text-blue-600">Rp
                        {{ number_format($product['sale_price'], 0, ',', '.') }}</span>
                @else
                    <span class="text-xl font-semibold text-blue-600">Rp
                        {{ number_format($product['price'], 0, ',', '.') }}</span>
                @endif
            </div>
            <div class="flex gap-3 mt-4">
                <button
                    class="flex-1 bg-blue-600 text-white rounded-full py-2.5 text-sm font-semibold hover:bg-blue-500 transition">Tambah
                    ke Keranjang</button>
                <a href="{{ url('product/' . $product['slug']) }}"
                    class="px-4 py-2.5 border border-gray-200 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 transition">Detail</a>
            </div>
        </div>
    </div>
</article>
