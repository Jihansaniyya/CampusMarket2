@extends('layouts.seller')

@section('title', 'Produk Anda')
@section('page-title', 'Produk Anda')
@section('page-description')
    Lihat dan kelola semua produk yang telah Anda upload.
@endsection

@section('content')

{{-- ===================== FILTER BAR (UI MIRIP UPLOAD PRODUK) ===================== --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">

    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
            <i class="fas fa-box text-white"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daftar Produk</h2>
            <p class="text-sm text-gray-500">Filter, cari, dan urutkan produk Anda.</p>
        </div>
    </div>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

        {{-- SEARCH --}}
        <div class="md:col-span-2">
            <input 
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama produk..."
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition"
            />
        </div>

        {{-- FILTER KATEGORI --}}
        <div>
            <select name="category"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition"
            >
                <option value="">Semua Kategori</option>
                <option value="Electronics"   {{ request('category')=='Electronics' ? 'selected':'' }}>Electronics</option>
                <option value="Fashion"       {{ request('category')=='Fashion' ? 'selected':'' }}>Fashion</option>
                <option value="Groceries"     {{ request('category')=='Groceries' ? 'selected':'' }}>Groceries</option>
                <option value="Home & Living" {{ request('category')=='Home & Living' ? 'selected':'' }}>Home & Living</option>
                <option value="Health & Beauty" {{ request('category')=='Health & Beauty'? 'selected':'' }}>Health & Beauty</option>
                <option value="Sport"         {{ request('category')=='Sport' ? 'selected':'' }}>Sport</option>
                <option value="Automotive"    {{ request('category')=='Automotive' ? 'selected':'' }}>Automotive</option>
                <option value="Books"         {{ request('category')=='Books' ? 'selected':'' }}>Books</option>
                <option value="Toys"          {{ request('category')=='Toys' ? 'selected':'' }}>Toys</option>
            </select>
        </div>

        {{-- FILTER KONDISI --}}
        <div>
            <select name="condition"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition"
            >
                <option value="">Kondisi</option>
                <option value="new"  {{ request('condition')=='new' ? 'selected':'' }}>Baru</option>
                <option value="used" {{ request('condition')=='used'? 'selected':'' }}>Bekas</option>
            </select>
        </div>

        {{-- SORT --}}
        <div>
            <select name="sort"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition"
            >
                <option value="">Urutkan: Terbaru</option>
                <option value="price_asc"  {{ request('sort')=='price_asc' ? 'selected':'' }}>Harga Termurah</option>
                <option value="price_desc" {{ request('sort')=='price_desc'? 'selected':'' }}>Harga Termahal</option>
                <option value="stock_desc" {{ request('sort')=='stock_desc'? 'selected':'' }}>Stok Tertinggi</option>
            </select>
        </div>

        {{-- BUTTON --}}
        <div>
            <button class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 rounded-xl shadow hover:brightness-110 transition text-sm font-semibold">
                Terapkan
            </button>
        </div>

    </form>
</div>



{{-- ===================== JIKA TIDAK ADA PRODUK ===================== --}}
@if($products->count() == 0)

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center">
    <div class="flex justify-center mb-4">
        <i class="fas fa-box-open text-gray-400 text-6xl"></i>
    </div>

    <h3 class="text-xl font-semibold text-gray-700">Belum ada produk</h3>
    <p class="text-gray-500 mb-4">Tambahkan produk pertama Anda untuk mulai berjualan.</p>

    <a href="{{ route('seller.products.create') }}"
       class="bg-indigo-600 text-white px-6 py-3 rounded-xl shadow hover:bg-indigo-700 transition">
        + Tambah Produk
    </a>
</div>

@else



{{-- ===================== LIST PRODUK ===================== --}}
<div class="space-y-4">

@foreach ($products as $p)

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex gap-4">

        {{-- FOTO --}}
        <img src="{{ asset('storage/'.$p->thumbnail) }}"
             class="w-24 h-24 rounded-xl object-cover">

        {{-- INFO --}}
        <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-900">{{ $p->name }}</h3>

            {{-- BADGES --}}
            <div class="flex gap-2 mt-1">

                {{-- STATUS --}}
                @if($p->status == 'publish')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Publish</span>
                @else
                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                @endif

                {{-- PREORDER --}}
                @if($p->preorder == 1)
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Pre-order</span>
                @endif

            </div>

            {{-- DETAIL --}}
            <p class="text-gray-600 mt-2 text-sm">
                Harga: <span class="font-bold">Rp {{ number_format($p->price) }}</span> • 
                Stok: <span class="font-semibold">{{ $p->stock }}</span>
            </p>

            <p class="text-gray-500 text-xs mt-1">Kategori: {{ $p->category }}</p>
            <p class="text-gray-500 text-xs">Kondisi: {{ $p->condition == 'new' ? 'Baru' : 'Bekas' }}</p>
        </div>

        {{-- ACTION --}}
        <div class="flex flex-col justify-between text-right">

            <a href="{{ route('seller.products.edit', $p->id) }}"
               class="text-indigo-600 hover:underline font-semibold text-sm">Edit</a>

            <form action="{{ route('seller.products.destroy', $p->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus produk ini?')">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline text-sm font-semibold">Hapus</button>
            </form>

        </div>
    </div>

@endforeach

</div>


{{-- PAGINATION --}}
<div class="mt-6">
    {{ $products->links() }}
</div>

@endif

@endsection
