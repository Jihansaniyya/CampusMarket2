<header class="bg-white shadow-sm sticky top-0 z-40" x-data="headerSearch()"
    @click.outside="showFilters = false; openGlobalSuggestions = false">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10 xl:px-12">
        <div class="flex items-center justify-between py-4 gap-4">
            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo1.png') }}" alt="CampusMarket" class="h-10 w-auto object-contain">
                    <span class="text-xl font-bold text-blue-600 leading-none hidden lg:block">CampusMarket</span>
                </a>
            </div>

            @php
                $filterCategories = \App\Models\Category::all();
                $filterStores = \App\Models\User::where('role', 'seller')
                    ->whereNotNull('store_name')
                    ->distinct()
                    ->pluck('store_name')
                    ->values();
                $globalStoreSuggestions = \App\Models\User::where('role', 'seller')
                    ->whereNotNull('store_name')
                    ->select('store_name', 'provinsi', 'kota_kab')
                    ->orderBy('store_name')
                    ->limit(200)
                    ->get()
                    ->map(
                        fn($seller) => [
                            'name' => $seller->store_name,
                            'location' => trim(
                                ($seller->kota_kab ?? '') .
                                    ($seller->kota_kab && $seller->provinsi ? ', ' : '') .
                                    ($seller->provinsi ?? ''),
                            ),
                            'url' => route('product.search', ['store_name' => $seller->store_name]),
                        ],
                    )
                    ->values();
                $globalProductSuggestions = \App\Models\Product::query()
                    ->with('seller:id,store_name')
                    ->where('is_active', true)
                    ->select('id', 'name', 'slug', 'thumbnail', 'price', 'seller_id')
                    ->latest('id')
                    ->limit(250)
                    ->get()
                    ->map(
                        fn($product) => [
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'thumbnail' => $product->thumbnail
                                ? \Illuminate\Support\Facades\Storage::url($product->thumbnail)
                                : null,
                            'store' => $product->seller?->store_name,
                            'price' => (int) $product->price,
                            'url' => route('product.show', $product->slug),
                        ],
                    )
                    ->values();
            @endphp

            {{-- Search Form --}}
            <form action="{{ route('product.search') }}" method="GET" autocomplete="off" x-ref="desktopSearchForm"
                class="flex-1 hidden md:flex mx-4">
                <div class="relative w-full">
                    <label for="search" class="sr-only">Cari produk</label>

                    {{-- Main Search Input --}}
                    <input id="search" type="text" name="product_name" x-model="search"
                        @focus="openGlobalSuggestions = search.trim().length > 0" @input="onGlobalSearchInput()"
                        @keydown.escape="openGlobalSuggestions = false" placeholder="Cari produk atau toko..."
                        autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                        class="w-full h-12 rounded-full border border-gray-200 pl-5 pr-24 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" />

                    {{-- Global Suggestions Dropdown --}}
                    <div x-show="openGlobalSuggestions && hasGlobalSuggestions()" x-transition @click.stop
                        class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-3 z-50 max-h-96 overflow-auto">
                        <template x-if="getMatchedStores().length > 0">
                            <div>
                                <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Toko
                                </p>
                                <div class="space-y-2">
                                    <template x-for="store in getMatchedStores()" :key="'global-store-' + store.name">
                                        <a :href="store.url"
                                            class="flex items-center justify-between gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div
                                                    class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 21h18M4 21V7a1 1 0 011-1h4a1 1 0 011 1v14m0 0h4m-4 0V11a1 1 0 011-1h2a1 1 0 011 1v10m0 0h4V5a1 1 0 00-1-1h-4a1 1 0 00-1 1v16" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 truncate"
                                                        x-text="store.name"></p>
                                                    <p class="text-sm text-gray-500 truncate"
                                                        x-text="store.location || 'Lokasi belum tersedia'"></p>
                                                </div>
                                            </div>
                                            <span
                                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-blue-50 text-blue-600 font-semibold shrink-0">
                                                Kunjungi
                                            </span>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="getMatchedProducts().length > 0">
                            <div class="pt-3"
                                :class="{ 'border-t border-gray-100 mt-3': getMatchedStores().length > 0 }">
                                <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">Produk
                                </p>
                                <div class="space-y-2">
                                    <template x-for="product in getMatchedProducts()"
                                        :key="'global-product-' + product.slug">
                                        <a :href="product.url"
                                            class="flex items-center gap-3 p-2.5 rounded-xl border border-gray-100 hover:bg-gray-50 transition">
                                            <img x-show="product.thumbnail" :src="product.thumbnail"
                                                :alt="product.name"
                                                class="w-11 h-11 rounded-lg object-cover shrink-0">
                                            <div x-show="!product.thumbnail"
                                                class="w-11 h-11 rounded-lg bg-gray-100 text-gray-400 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm3 8 2.5-3 2 2.5 3.5-4.5L18 15H6z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 truncate"
                                                    x-text="product.name"></p>
                                                <p class="text-xs text-gray-500 truncate"
                                                    x-text="product.store || 'Toko tidak diketahui'"></p>
                                            </div>
                                            <p class="text-sm font-semibold text-blue-600 shrink-0"
                                                x-text="formatRupiah(product.price)"></p>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Filter Button --}}
                    <button type="button" @click="showFilters = !showFilters"
                        class="absolute right-13 top-1/2 -translate-y-1/2 p-1.5 text-gray-400 hover:text-blue-600 transition"
                        title="Filter Lanjutan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </button>

                    {{-- Search / Clear Button --}}
                    <button type="button" @click.prevent="onSearchButtonClick($event)"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white w-9 h-9 rounded-full flex items-center justify-center transition"
                        :title="hasActiveSearch ? 'Hapus pencarian' : 'Cari'">
                        <template x-if="!hasActiveSearch">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                            </svg>
                        </template>
                        <template x-if="hasActiveSearch">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </template>
                    </button>

                    {{-- Advanced Filter Dropdown --}}
                    <div x-show="showFilters" x-transition @click.stop
                        class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 z-50">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Store Name --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Toko</label>
                                <div class="relative" @click.outside="openStoreDropdown = false">
                                    <input type="text" name="store_name" x-model="storeName"
                                        @focus="openStoreDropdown = storeName.trim().length > 0"
                                        @input="onStoreInput()" placeholder="Cari toko..." autocomplete="off"
                                        autocorrect="off" autocapitalize="off" spellcheck="false"
                                        class="w-full px-3 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                    <button type="button" @click="openStoreDropdown = !openStoreDropdown"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>

                                    <div x-show="openStoreDropdown && getFilteredStores().length > 0" x-transition
                                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-56 overflow-auto">
                                        <template x-for="store in getFilteredStores()" :key="'store-' + store">
                                            <button type="button" @click="selectStoreName(store)"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                x-text="store"></button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kategori</label>
                                <input type="hidden" name="category_id" :value="categoryId">
                                <div class="relative" @click.outside="openCategoryDropdown = false">
                                    <input type="text" x-model="categoryName" @focus="openCategoryDropdown = true"
                                        @input="syncCategoryId(); openCategoryDropdown = true"
                                        placeholder="Semua Kategori" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" spellcheck="false"
                                        class="w-full px-3 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                    <button type="button" @click="openCategoryDropdown = !openCategoryDropdown"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>
                                    <div x-show="openCategoryDropdown" x-transition
                                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-56 overflow-auto">
                                        <button type="button"
                                            @click="categoryName=''; categoryId=''; openCategoryDropdown=false"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700">Semua
                                            Kategori</button>
                                        <template x-for="cat in getFilteredCategories()" :key="'cat-' + cat.id">
                                            <button type="button" @click="selectCategory(cat)"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                x-text="cat.name"></button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Province --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Provinsi</label>
                                <div class="relative" @click.outside="openProvinceDropdown = false">
                                    <input type="text" name="province" x-model="selectedProvince"
                                        @focus="openProvinceDropdown = true"
                                        @input="onProvinceInput(); openProvinceDropdown = true"
                                        placeholder="Semua Provinsi" autocomplete="off" autocorrect="off"
                                        autocapitalize="off" spellcheck="false"
                                        class="w-full px-3 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                    <button type="button" @click="openProvinceDropdown = !openProvinceDropdown"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>
                                    <div x-show="openProvinceDropdown" x-transition
                                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-56 overflow-auto">
                                        <button type="button"
                                            @click="selectedProvince=''; selectedCity=''; cities=[]; openProvinceDropdown=false"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700">Semua
                                            Provinsi</button>
                                        <template x-for="prov in getFilteredProvinces()" :key="'prov-' + prov.id">
                                            <button type="button" @click="selectProvince(prov)"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                x-text="prov.name"></button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- City --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kota/Kabupaten</label>
                                <div class="relative" @click.outside="openCityDropdown = false">
                                    <input type="text" name="city" x-model="selectedCity"
                                        :disabled="!selectedProvince || loadingCities"
                                        @focus="if (selectedProvince && !loadingCities) openCityDropdown = true"
                                        @input="openCityDropdown = true"
                                        :placeholder="loadingCities ? 'Memuat...' : (selectedProvince ? 'Pilih Kota/Kabupaten' :
                                            'Pilih provinsi dulu')"
                                        autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                        class="w-full px-3 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <button type="button"
                                        @click="if (selectedProvince && !loadingCities) openCityDropdown = !openCityDropdown"
                                        :disabled="!selectedProvince || loadingCities"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 disabled:opacity-40">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>
                                    <div x-show="openCityDropdown && selectedProvince && !loadingCities" x-transition
                                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-56 overflow-auto">
                                        <button type="button" @click="selectedCity=''; openCityDropdown=false"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700">Semua
                                            Kota/Kabupaten</button>
                                        <template x-for="city in getFilteredCities()" :key="'city-' + city.id">
                                            <button type="button" @click="selectCity(city)"
                                                class="w-full text-left px-3 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                x-text="city.name"></button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Filter Actions --}}
                        <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('home') }}"
                                class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">
                                Reset
                            </a>
                            <button type="submit" name="refine" value="1"
                                class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-gray-700 hover:text-blue-600 border border-blue-500 px-4 py-2 rounded-full hover:bg-blue-50 transition hidden sm:block">Masuk</a>
                <a href="{{ route('register') }}"
                    class="text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-full hover:bg-blue-500 transition">Daftar</a>
            </div>
        </div>

        {{-- Mobile Search --}}
        <form action="{{ route('product.search') }}" method="GET" autocomplete="off" x-ref="mobileSearchForm"
            class="md:hidden pb-4">
            <div class="relative">
                <label for="search-mobile" class="sr-only">Cari produk</label>
                <input id="search-mobile" type="text" name="product_name" x-model="search"
                    placeholder="Cari produk atau toko..." autocomplete="off" autocorrect="off" autocapitalize="off"
                    spellcheck="false"
                    class="w-full h-12 rounded-full border border-gray-200 pl-5 pr-14 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" />
                <button type="button" @click.prevent="onSearchButtonClick($event)"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white w-9 h-9 rounded-full flex items-center justify-center transition"
                    :title="hasActiveSearch ? 'Hapus pencarian' : 'Cari'">
                    <template x-if="!hasActiveSearch">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </template>
                    <template x-if="hasActiveSearch">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </template>
                </button>
            </div>
        </form>
    </div>
</header>

<script>
    function headerSearch() {
        return {
            search: @js(request('product_name') ?: request('store_name', '')),
            hasActiveSearch: @js(request()->filled('product_name') || request()->filled('store_name') || request()->filled('category_id') || request()->filled('province') || request()->filled('city')),
            homeUrl: @js(route('home')),
            showFilters: false,
            openGlobalSuggestions: false,
            storeName: '{{ request('store_name', '') }}',
            categoryId: '{{ request('category_id', '') }}',
            categoryName: '',
            selectedProvince: '{{ request('province', '') }}',
            selectedCity: '{{ request('city', '') }}',
            openStoreDropdown: false,
            openCategoryDropdown: false,
            openProvinceDropdown: false,
            openCityDropdown: false,
            globalStoreSuggestions: @js($globalStoreSuggestions),
            globalProductSuggestions: @js($globalProductSuggestions),
            storeOptions: @js($filterStores),
            categoryOptions: @js($filterCategories->map(fn($cat) => ['id' => (string) $cat->id, 'name' => $cat->name])->values()),
            provinces: [],
            cities: [],
            loadingCities: false,

            init() {
                this.fetchProvinces();

                const selectedCategory = this.categoryOptions.find(cat => cat.id === String(this.categoryId));
                if (selectedCategory) {
                    this.categoryName = selectedCategory.name;
                }

                // If there's a selected province from request, fetch cities
                if (this.selectedProvince) {
                    this.fetchCities();
                }
            },

            onStoreInput() {
                this.openStoreDropdown = this.storeName.trim().length > 0;
            },

            onGlobalSearchInput() {
                this.openGlobalSuggestions = this.search.trim().length > 0;
            },

            onSearchButtonClick(event) {
                if (this.hasActiveSearch) {
                    window.location.href = this.homeUrl;
                    return;
                }

                const form = event?.target?.closest('form');
                if (form) {
                    form.submit();
                }
            },

            getMatchedStores() {
                const keyword = (this.search || '').trim().toLowerCase();
                if (!keyword) return [];

                return this.globalStoreSuggestions
                    .filter(store => String(store.name).toLowerCase().includes(keyword))
                    .slice(0, 4);
            },

            getMatchedProducts() {
                const keyword = (this.search || '').trim().toLowerCase();
                if (!keyword) return [];

                return this.globalProductSuggestions
                    .filter(product => String(product.name).toLowerCase().includes(keyword))
                    .slice(0, 6);
            },

            hasGlobalSuggestions() {
                return this.getMatchedStores().length > 0 || this.getMatchedProducts().length > 0;
            },

            formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0,
                }).format(Number(value || 0));
            },

            getFilteredStores() {
                const keyword = (this.storeName || '').trim().toLowerCase();
                if (!keyword) return [];

                return this.storeOptions.filter(store => String(store).toLowerCase().includes(keyword)).slice(0, 10);
            },

            selectStoreName(store) {
                this.storeName = store;
                this.openStoreDropdown = false;
            },

            getFilteredCategories() {
                const keyword = (this.categoryName || '').trim().toLowerCase();
                if (!keyword) return this.categoryOptions;

                return this.categoryOptions.filter(cat => cat.name.toLowerCase().includes(keyword));
            },

            getFilteredProvinces() {
                const keyword = (this.selectedProvince || '').trim().toLowerCase();
                if (!keyword) return this.provinces;

                return this.provinces.filter(prov => prov.name.toLowerCase().includes(keyword));
            },

            getFilteredCities() {
                const keyword = (this.selectedCity || '').trim().toLowerCase();
                if (!keyword) return this.cities;

                return this.cities.filter(city => city.name.toLowerCase().includes(keyword));
            },

            syncCategoryId() {
                const input = (this.categoryName || '').trim().toLowerCase();
                const selected = this.categoryOptions.find(cat => cat.name.toLowerCase() === input);
                this.categoryId = selected ? selected.id : '';
            },

            selectCategory(cat) {
                this.categoryName = cat.name;
                this.categoryId = cat.id;
                this.openCategoryDropdown = false;
            },

            selectProvince(prov) {
                this.selectedProvince = prov.name;
                this.openProvinceDropdown = false;
                this.fetchCities();
            },

            selectCity(city) {
                this.selectedCity = city.name;
                this.openCityDropdown = false;
            },

            onProvinceInput() {
                if (!this.selectedProvince) {
                    this.selectedCity = '';
                    this.cities = [];
                }
            },

            async fetchProvinces() {
                try {
                    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await response.json();
                } catch (error) {
                    console.error('Error fetching provinces:', error);
                }
            },

            async fetchCities() {
                if (!this.selectedProvince) {
                    this.cities = [];
                    this.selectedCity = '';
                    return;
                }

                this.loadingCities = true;
                this.selectedCity = '';

                try {
                    // Find province ID by name
                    const province = this.provinces.find(p => p.name === this.selectedProvince);
                    if (province) {
                        const response = await fetch(
                            `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${province.id}.json`);
                        this.cities = await response.json();
                    }
                } catch (error) {
                    console.error('Error fetching cities:', error);
                } finally {
                    this.loadingCities = false;
                }
            }
        }
    }
</script>
