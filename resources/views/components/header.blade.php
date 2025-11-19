<header class="bg-white shadow-sm sticky top-0 z-40" x-data="{
    search: '',
    showSuggestions: false,
    suggestions: ['Wireless Earbuds', 'Standing Desk', 'Face Serum', 'Gaming Mouse', 'Sneakers'],
    filtered() {
        return this.suggestions
            .filter(item => item.toLowerCase().includes(this.search.toLowerCase()))
            .slice(0, 5);
    }
}" @click.outside="showSuggestions = false">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10 xl:px-12">
        <div class="flex items-center justify-between py-4 gap-5">
            <div class="flex items-center gap-5">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('assets/logo1.png') }}" alt="CampusMarket" class="h-11 w-auto object-contain">
                    <span class="text-2xl font-bold text-blue-600 leading-none">CampusMarket</span>
                </a>
                <a href="#"
                    class="text-base text-gray-700 hover:text-blue-600 hidden lg:block font-medium">Kategori</a>
            </div>

            <div class="flex-1 hidden md:flex max-w-2xl mx-4">
                <div class="relative w-full">
                    <label for="search" class="sr-only">Cari produk</label>
                    <input id="search" type="text" x-model="search" @focus="showSuggestions = true"
                        @input.debounce.200ms="showSuggestions = true" placeholder="Cari produk, toko, dan kategori"
                        class="w-full h-12 rounded-full border border-gray-200 px-5 pr-14 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" />
                    <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                    <div x-show="showSuggestions && search.length" x-transition
                        class="absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                        <template x-if="!filtered().length">
                            <p class="px-4 py-3 text-sm text-gray-500">Tidak ada saran</p>
                        </template>
                        <template x-for="item in filtered()" :key="item">
                            <button type="button"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center gap-2 text-sm"
                                @click="search = item; showSuggestions = false">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                                </svg>
                                <span x-text="item"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative p-2.5 text-gray-600 hover:text-blue-600 transition">
                    <span class="sr-only">Keranjang</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.436M7.5 14.25a3 3 0 1 0 5.999.001A3 3 0 0 0 7.5 14.25Zm8.25 0a3 3 0 1 0 5.999.001A3 3 0 0 0 15.75 14.25Zm.75-5.25h-9m12 0h-1.5m-9.75 0L6.75 5.25m0 0H19.5m-12.75 0L5.25 3" />
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-orange-400 text-white text-xs rounded-full px-1.5">3</span>
                </button>
                <div class="h-6 w-px bg-gray-300 hidden sm:block"></div>
                <a href="{{ route('login') }}"
                    class="text-base font-medium text-gray-700 hover:text-blue-600 border border-blue-500 px-5 py-2.5 rounded-full hover:bg-blue-50 transition hidden sm:block">Masuk</a>
                <a href="{{ route('register') }}"
                    class="text-base font-medium text-white bg-blue-600 px-5 py-2.5 rounded-full hover:bg-blue-500 transition">Daftar</a>
            </div>
        </div>

        <div class="md:hidden pb-4">
            <div class="relative">
                <label for="search-mobile" class="sr-only">Cari produk</label>
                <input id="search-mobile" type="text" placeholder="Cari produk..."
                    class="w-full h-12 rounded-full border border-gray-200 px-5 pr-14 text-base focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none" />
                <svg class="absolute right-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                </svg>
            </div>
        </div>
    </div>
</header>
