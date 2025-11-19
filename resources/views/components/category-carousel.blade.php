@props(['categories'])

<section id="categories" class="mt-8">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Kategori Pilihan</h2>
    <div class="flex gap-3 overflow-x-auto scrollbar-none pb-2">
        @foreach ($categories as $category)
            <a href="#"
               class="flex-shrink-0 w-32 bg-white border border-gray-100 rounded-xl p-4 text-center hover:border-blue-500 hover:shadow-lg transition flex flex-col items-center gap-2"
            >
                <span class="text-2xl" aria-hidden="true">{{ $category['icon'] }}</span>
                <span class="text-sm font-medium text-gray-700">{{ $category['name'] }}</span>
            </a>
        @endforeach
    </div>
</section>