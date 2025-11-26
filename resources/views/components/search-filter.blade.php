<!-- Search Bar Component -->
<div class="max-w-screen-2xl mx-auto w-full px-4 sm:px-6 lg:px-10 xl:px-12 py-6">
    <form action="{{ route('product.search') }}" method="GET" class="space-y-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Cari Produk</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- Product Name Input -->
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk
                    </label>
                    <input 
                        type="text" 
                        id="product_name" 
                        name="product_name" 
                        value="{{ request('product_name') }}"
                        placeholder="Cari produk..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Store Name Input -->
                <div>
                    <label for="store_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Toko
                    </label>
                    <input 
                        type="text" 
                        id="store_name" 
                        name="store_name" 
                        value="{{ request('store_name') }}"
                        placeholder="Cari toko..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Category Select -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori
                    </label>
                    <select 
                        id="category_id" 
                        name="category_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($categories ?? [] as $category)
                            @php
                                $catId = is_array($category) ? ($category['id'] ?? null) : ($category->id ?? null);
                                $catName = is_array($category) ? ($category['name'] ?? '') : ($category->name ?? '');
                            @endphp
                            <option value="{{ $catId }}" {{ request('category_id') == $catId ? 'selected' : '' }}>
                                {{ $catName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Province Select -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-1">
                        Provinsi
                    </label>
                    <select 
                        id="province" 
                        name="province"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Semua Provinsi</option>
                        @foreach ($provinces ?? [] as $prov)
                            <option value="{{ $prov }}" {{ request('province') == $prov ? 'selected' : '' }}>
                                {{ $prov }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- City/District Select -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                        Kota/Kabupaten
                    </label>
                    <select 
                        id="city" 
                        name="city"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Semua Kota/Kabupaten</option>
                        @foreach ($cities ?? [] as $cty)
                            <option value="{{ $cty }}" {{ request('city') == $cty ? 'selected' : '' }}>
                                {{ $cty }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-4">
                <button 
                    type="submit" 
                    class="flex-1 md:flex-initial bg-blue-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-blue-500 transition"
                >
                    <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
                <a 
                    href="{{ route('home') }}" 
                    class="bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-400 transition"
                >
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
