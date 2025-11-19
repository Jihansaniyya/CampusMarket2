<div
    x-cloak
    x-show="$store.quickView.open"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="quick-view-title"
>
    <div
        id="quick-view-modal"
        tabindex="-1"
        class="bg-white rounded-3xl max-w-3xl w-full overflow-hidden shadow-2xl focus:outline-none"
    >
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <div>
                <p id="quick-view-title" class="text-lg font-semibold" x-text="$store.quickView.product.name"></p>
                <p class="text-sm text-gray-500">Lihat detail produk sebelum membeli</p>
            </div>
            <button @click="$store.quickView.closeModal()" class="text-gray-400 hover:text-gray-600" aria-label="Tutup quick view">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="grid md:grid-cols-2">
            <div class="p-6 bg-gray-50">
                <img :src="$store.quickView.product.image_url" :alt="$store.quickView.product.name" class="rounded-2xl w-full h-80 object-cover" loading="lazy">
            </div>
            <div class="p-6 flex flex-col gap-4">
                <p class="text-sm text-gray-600" x-text="$store.quickView.product.short_description"></p>
                <div class="flex items-center gap-2 text-amber-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z" />
                    </svg>
                    <span class="font-semibold" x-text="$store.quickView.product.rating ?? '4.5'"></span>
                    <span class="text-gray-400" x-text="'(' + ($store.quickView.product.reviews_count ?? 0) + ' reviews)'"></span>
                </div>
                <div class="flex items-baseline gap-2">
                    <template x-if="$store.quickView.product.sale_price">
                        <span class="text-sm text-gray-400 line-through" x-text="'Rp ' + Number($store.quickView.product.price).toLocaleString('id-ID')"></span>
                    </template>
                    <span class="text-3xl font-bold text-blue-600" x-text="'Rp ' + Number($store.quickView.product.sale_price ?? $store.quickView.product.price).toLocaleString('id-ID')"></span>
                </div>
                <div class="flex gap-3 pt-4">
                    <button class="flex-1 bg-blue-600 text-white rounded-full py-3 font-semibold hover:bg-blue-500 transition">Tambah ke Keranjang</button>
                    <a :href="`/product/${$store.quickView.product.slug}`" class="px-6 py-3 border border-gray-200 rounded-full font-semibold text-gray-700 hover:border-blue-500 hover:text-blue-600 transition">Lihat Produk</a>
                </div>
            </div>
        </div>
    </div>
</div>