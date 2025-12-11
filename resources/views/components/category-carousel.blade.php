@props(['categories'])

<section id="categories" class="mt-8 relative z-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Kategori Pilihan</h2>
        @if (request()->get('category_id'))
            <a href="{{ route('product.search') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                ✕ Reset
            </a>
        @endif
    </div>
    <div class="flex gap-4 overflow-x-auto scrollbar-none pb-2">
        @foreach ($categories as $category)
            <a href="{{ route('product.search', ['category_id' => $category['id']]) }}"
                class="shrink-0 min-w-[130px] bg-gradient-to-b from-white to-gray-50 border rounded-2xl px-6 py-5 text-center hover:shadow-lg hover:border-blue-400 hover:-translate-y-1 transition-all duration-200 flex flex-col items-center gap-3 group
                      {{ request()->get('category_id') == $category['id'] ? 'border-blue-500 bg-gradient-to-b from-blue-50 to-blue-100 shadow-md' : 'border-gray-200' }}">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center transition-all duration-200
                    {{ request()->get('category_id') == $category['id'] ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-200' }}">
                    {!! $category['icon'] !!}
                </div>
                <span class="text-sm font-semibold whitespace-nowrap {{ request()->get('category_id') == $category['id'] ? 'text-blue-700' : 'text-gray-700 group-hover:text-blue-600' }}">{{ $category['name'] }}</span>
            </a>
        @endforeach
    </div>
</section>
