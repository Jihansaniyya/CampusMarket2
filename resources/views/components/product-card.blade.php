@props(['product'])

@php
    // Handle both array and Model object
    $isArray = is_array($product);
    $name = $isArray ? $product['name'] : $product->name;
    $slug = $isArray ? $product['slug'] : $product->slug;
    $price = $isArray ? $product['price'] : $product->price;
    $salePrice = $isArray ? $product['sale_price'] ?? null : $product->sale_price;

    // Calculate actual rating from reviews
    if ($isArray) {
        $rating = $product['rating'] ?? 0;
    } else {
        // For Model objects, calculate from reviews
        $rating = $product->reviews()->avg('rating') ?? 0;
        $rating = round($rating, 1);
    }

    $location = $isArray
        ? $product['location'] ?? null
        : $product->seller->kota_kab ?? ($product->seller->provinsi ?? null);
    $badge = $salePrice ? 'Sale' : null;

    // Handle image URL
    if ($isArray) {
        $imageUrl =
            $product['image_url'] ??
            'https://placehold.co/400x400/EEF2FF/4F46E5?text=' . urlencode(substr($name, 0, 20));
    } else {
        $thumbnail = $product->thumbnail;
        if ($thumbnail) {
            $imageUrl = str_starts_with($thumbnail, 'http') ? $thumbnail : asset('storage/' . $thumbnail);
        } else {
            $imageUrl = 'https://placehold.co/400x400/EEF2FF/4F46E5?text=' . urlencode(substr($name, 0, 20));
        }
    }

    $productJson = Illuminate\Support\Js::from($product);
@endphp

<article class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition flex flex-col">
    <div class="relative">
        <img src="{{ $imageUrl }}" alt="{{ $name }}" loading="lazy"
            class="w-full h-56 object-cover rounded-t-2xl bg-gray-100"
            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'400\'%3E%3Crect width=\'400\' height=\'400\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'Arial\' font-size=\'20\'%3E{{ $name }}%3C/text%3E%3C/svg%3E';">
        @if ($badge)
            <span
                class="absolute top-4 left-4 bg-orange-400 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">{{ $badge }}</span>
        @endif
        <button type="button"
            class="absolute top-4 right-4 bg-white/90 backdrop-blur border border-gray-200 rounded-full p-2 text-gray-700 hover:text-blue-600"
            @click="$store.quickView.openModal({{ $productJson }})" aria-label="Quick view {{ $name }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
            </svg>
        </button>
    </div>
    <div class="p-5 flex flex-col gap-3 flex-1">
        <div>
            <h3 class="text-base font-semibold text-gray-900 line-clamp-2">{{ $name }}</h3>
        </div>
        @if ($location)
            <p class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $location }}
            </p>
        @endif
        <div class="mt-auto">
            <div class="flex items-center justify-between">
                <div>
                    @if ($salePrice)
                        <span class="text-lg font-semibold text-blue-600">Rp
                            {{ number_format($salePrice, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-400 line-through block">Rp
                            {{ number_format($price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-lg font-semibold text-blue-600">Rp
                            {{ number_format($price, 0, ',', '.') }}</span>
                    @endif
                </div>
                @if ($rating > 0)
                    <div class="flex items-center gap-1 text-sm text-amber-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                        </svg>
                        <span class="font-semibold">{{ number_format($rating, 1) }}</span>
                    </div>
                @else
                    <div class="text-xs text-gray-400">
                        Belum ada rating
                    </div>
                @endif
            </div>
            <div class="mt-4">
                <a href="{{ url('product/' . $slug) }}"
                    class="block w-full text-center py-2.5 border border-gray-200 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 transition">Lihat
                    Detail</a>
            </div>
        </div>
    </div>
</article>
