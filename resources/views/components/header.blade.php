<header class="bg-white shadow-sm sticky top-0 z-40" x-data="headerSearch()" @click.outside="showFilters = false">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10 xl:px-12">
        <div class="flex items-center justify-between py-4 gap-4">
            <div class="flex items-center gap-4 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/logo1.png') }}" alt="CampusMarket" class="h-10 w-auto object-contain">
                    <span class="text-xl font-bold text-blue-600 leading-none hidden lg:block">CampusMarket</span>
                </a>
            </div>

            {{-- Search Form --}}
            <form action="{{ route('product.search') }}" method="GET" class="flex-1 hidden md:flex mx-4">
                <div class="relative w-full">
                    <label for="search" class="sr-only">Cari produk</label>
                    
                    {{-- Main Search Input --}}
                    <input 
                        id="search" 
                        type="text" 
                        name="product_name"
                        x-model="search"
                        placeholder="Cari produk, toko, dan kategori..." 
                        class="w-full h-12 rounded-full border border-gray-200 pl-5 pr-24 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition"
                    />
                    
                    {{-- Filter Button --}}
                    <button 
                        type="button"
                        @click="showFilters = !showFilters"
                        class="absolute right-14 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-blue-600 transition"
                        title="Filter Lanjutan"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </button>
                    
                    {{-- Search Button --}}
                    <button 
                        type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-full transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                        </svg>
                    </button>

                    {{-- Advanced Filter Dropdown --}}
                    <div 
                        x-show="showFilters" 
                        x-transition
                        @click.stop
                        class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 z-50"
                    >
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Store Name --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Nama Toko</label>
                                <input 
                                    type="text" 
                                    name="store_name" 
                                    x-model="storeName"
                                    placeholder="Cari toko..." 
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                >
                            </div>
                            
                            {{-- Category --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kategori</label>
                                @php
                                    $filterCategories = \App\Models\Category::all();
                                @endphp
                                <select 
                                    name="category_id"
                                    x-model="categoryId"
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition appearance-none cursor-pointer"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%239CA3AF%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;"
                                >
                                    <option value="">Semua Kategori</option>
                                    @foreach($filterCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Province --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Provinsi</label>
                                <select 
                                    name="province"
                                    x-model="selectedProvince"
                                    @change="fetchCities()"
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition appearance-none cursor-pointer"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%239CA3AF%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;"
                                >
                                    <option value="">Semua Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.id">
                                        <option :value="prov.name" x-text="prov.name"></option>
                                    </template>
                                </select>
                            </div>
                            
                            {{-- City --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kota/Kabupaten</label>
                                <select 
                                    name="city"
                                    x-model="selectedCity"
                                    :disabled="!selectedProvince || loadingCities"
                                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%239CA3AF%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem;"
                                >
                                    <option value="">
                                        <span x-text="loadingCities ? 'Memuat...' : (selectedProvince ? 'Pilih Kota/Kab' : 'Pilih provinsi dulu')"></span>
                                    </option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.name" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        
                        {{-- Filter Actions --}}
                        <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('home') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">
                                Reset
                            </a>
                            <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
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
        <form action="{{ route('product.search') }}" method="GET" class="md:hidden pb-4">
            <div class="relative">
                <label for="search-mobile" class="sr-only">Cari produk</label>
                <input 
                    id="search-mobile" 
                    type="text" 
                    name="product_name"
                    value="{{ request('product_name') }}"
                    placeholder="Cari produk, toko, kategori..."
                    class="w-full h-12 rounded-full border border-gray-200 pl-5 pr-14 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" 
                />
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</header>

<script>
function headerSearch() {
    return {
        search: '{{ request('product_name', '') }}',
        showFilters: false,
        storeName: '{{ request('store_name', '') }}',
        categoryId: '{{ request('category_id', '') }}',
        selectedProvince: '{{ request('province', '') }}',
        selectedCity: '{{ request('city', '') }}',
        provinces: [],
        cities: [],
        loadingCities: false,

        init() {
            this.fetchProvinces();
            // If there's a selected province from request, fetch cities
            if (this.selectedProvince) {
                this.fetchCities();
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
                    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${province.id}.json`);
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
