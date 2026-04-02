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

    $ratingCount = $isArray ? $product['rating_count'] ?? 0 : $product->rating_count ?? 0;
    $storeName = $isArray ? $product['store_name'] ?? null : $product->seller->store_name ?? null;

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

@endphp

<a href="{{ url('product/' . $slug) }}" class="block h-full group">
    <article
        class="h-full bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition flex flex-col">
        <div class="relative">
            <img src="{{ $imageUrl }}" alt="{{ $name }}" loading="lazy"
                class="w-full h-32 object-cover rounded-t-xl bg-gray-100"
                onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'400\'%3E%3Crect width=\'400\' height=\'400\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'Arial\' font-size=\'20\'%3E{{ $name }}%3C/text%3E%3C/svg%3E';">
            @if ($badge)
                <span
                    class="absolute top-2 left-2 bg-orange-400 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wide">{{ $badge }}</span>
            @endif
        </div>
        <div class="p-3 flex flex-col gap-1.5 flex-1">
            <h3 class="text-[17px] font-semibold text-gray-900 line-clamp-1 leading-tight">{{ $name }}</h3>

            <p class="text-xs text-gray-500 flex items-center gap-1 line-clamp-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9.75L12 4l9 5.75V20a1 1 0 01-1 1h-5.5a.5.5 0 01-.5-.5V15a2 2 0 00-4 0v5.5a.5.5 0 01-.5.5H4a1 1 0 01-1-1V9.75z" />
                </svg>
                <span class="line-clamp-1">{{ $storeName ?: 'Toko belum diatur' }}</span>
            </p>

            <p class="text-xs text-gray-400 flex items-center gap-1 line-clamp-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $location ?: 'Lokasi belum diatur' }}
            </p>

            <div class="mt-auto pt-0.5">
                <div>
                    @if ($salePrice)
                        <span class="text-base font-semibold text-blue-600">Rp
                            {{ number_format($salePrice, 0, ',', '.') }}</span>
                        <span class="text-[11px] text-gray-400 line-through block">Rp
                            {{ number_format($price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-base font-semibold text-blue-600">Rp
                            {{ number_format($price, 0, ',', '.') }}</span>
                        <span class="text-[11px] invisible block">Rp 0</span>
                    @endif
                </div>

                <div class="mt-1 flex items-center gap-1.5 text-xs">
                    @if ($rating > 0)
                        <span class="text-amber-500 font-medium">★ {{ number_format($rating, 1) }}</span>
                    @else
                        <span class="text-gray-400">Belum ada rating</span>
                    @endif

                    @if ($ratingCount > 0)
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-500">{{ number_format($ratingCount) }} ulasan</span>
                    @endif
                </div>
            </div>
        </div>
    </article>
</a>
