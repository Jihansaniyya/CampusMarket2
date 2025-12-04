@props(['categories'])

<section id="categories" class="mt-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">Kategori Pilihan</h2>
        @if (request()->get('category'))
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                <i class="fas fa-times-circle mr-1"></i>Reset Filter
            </a>
        @endif
    </div>
    <div class="flex gap-3 overflow-x-auto scrollbar-none pb-2">
        @foreach ($categories as $category)
            <a href="{{ route('home', ['category' => $category['id']]) }}"
                class="flex-shrink-0 w-32 bg-white border rounded-xl p-4 text-center hover:border-blue-500 hover:shadow-lg transition flex flex-col items-center gap-2
                      {{ request()->get('category') == $category['id'] ? 'border-blue-500 bg-blue-50' : 'border-gray-100' }}">
                <span class="text-2xl" aria-hidden="true">{{ $category['icon'] }}</span>
                <span
                    class="text-sm font-medium {{ request()->get('category') == $category['id'] ? 'text-blue-600' : 'text-gray-700' }}">{{ $category['name'] }}</span>
            </a>
        @endforeach
    </div>
</section>
