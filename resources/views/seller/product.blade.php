@extends('layouts.seller')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')
@section('page-description')
    Lengkapi detail produk anda agar mudah ditemukan.
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper     = document.getElementById('preorder-toggle-wrapper');
    const checkbox    = document.getElementById('preorder-toggle');
    const hiddenInput = document.getElementById('preorder-value');
    const poDays      = document.getElementById('po-days');
    const track       = document.getElementById('preorder-track');

    if (!wrapper || !checkbox || !hiddenInput || !poDays || !track) return;

    function syncPreorderUI() {
        if (checkbox.checked) {
            hiddenInput.value = 1;
            poDays.classList.remove('hidden');
            track.classList.remove('bg-gray-300', 'justify-start');
            track.classList.add('bg-blue-500', 'justify-end');
        } else {
            hiddenInput.value = 0;
            poDays.classList.add('hidden');
            track.classList.add('bg-gray-300', 'justify-start');
            track.classList.remove('bg-blue-500', 'justify-end');
        }
    }

    wrapper.addEventListener('click', function (e) {
        e.preventDefault();
        checkbox.checked = !checkbox.checked;
        syncPreorderUI();
    });

    syncPreorderUI();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('preview');

    input.addEventListener('change', function () {
        previewContainer.innerHTML = "";

        if (input.files && input.files[0]) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(input.files[0]);
            img.className = "w-40 h-40 object-cover rounded-xl border mt-2";
            previewContainer.appendChild(img);
        }
    });
});
</script>
@endpush

@section('content')

    {{-- ALERT VALIDASI --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">Ada beberapa data yang perlu dicek lagi:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- ================= FOTO PRODUK ================= --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-linear-to-br from-purple-500 to-violet-600 flex items-center justify-center">
            <i class="fas fa-images text-white"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Foto Produk <span class="text-red-500">*</span></h2>
            <p class="text-sm text-gray-500">Minimal 1 foto utama</p>
        </div>
    </div>

    {{-- TILE TAMBAH FOTO --}}
    <label
        for="thumbnail"
        class="w-40 h-40 border-2 border-dashed border-red-300 rounded-xl flex flex-col items-center justify-center text-red-500 cursor-pointer hover:bg-red-50 transition"
    >
        <span class="text-2xl font-bold">+</span>
        <span class="text-sm font-semibold">Tambah Foto</span>
    </label>

    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="hidden">

    {{-- PREVIEW --}}
    <div id="preview" class="mt-3"></div>
</div>



        {{-- ============== INFORMASI PRODUK ============== --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-box-open text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Informasi Produk</h2>
                    <p class="text-sm text-gray-500">Nama, kategori, dan deskripsi produk.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Charger Aki Motor 12V Otomatis"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                    />
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori Utama <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="category"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                    >
                        <option value="">Pilih kategori</option>
                        <option value="Electronics"   {{ old('category') == 'Electronics'   ? 'selected' : '' }}>Electronics</option>
                        <option value="Fashion"       {{ old('category') == 'Fashion'       ? 'selected' : '' }}>Fashion</option>
                        <option value="Groceries"     {{ old('category') == 'Groceries'     ? 'selected' : '' }}>Groceries</option>
                        <option value="Home & Living" {{ old('category') == 'Home & Living' ? 'selected' : '' }}>Home & Living</option>
                        <option value="Health & Beauty" {{ old('category') == 'Health & Beauty' ? 'selected' : '' }}>Health & Beauty</option>
                        <option value="Sport"         {{ old('category') == 'Sport'         ? 'selected' : '' }}>Sport</option>
                        <option value="Automotive"    {{ old('category') == 'Automotive'    ? 'selected' : '' }}>Automotive</option>
                        <option value="Books"         {{ old('category') == 'Books'         ? 'selected' : '' }}>Books</option>
                        <option value="Toys"          {{ old('category') == 'Toys'          ? 'selected' : '' }}>Toys</option>
                    </select>
                </div>

                {{-- SKU --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        SKU (Opsional)
                    </label>
                    <input
                        type="text"
                        name="sku"
                        value="{{ old('sku') }}"
                        placeholder="Contoh: CM-CHARGER-001"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                    >
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Produk <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Tulis deskripsi produk..."
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                    >{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ============== HARGA & STOK ============== --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center">
                    <i class="fas fa-tags text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Harga & Stok</h2>
                    <p class="text-sm text-gray-500">Atur harga jual, stok, dan minimal pembelian.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="price"
                        value="{{ old('price') }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 150000"
                    >
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="stock"
                        value="{{ old('stock') }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 50"
                    >
                </div>

                {{-- Minimal Order --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Minimal Pembelian
                    </label>
                    <input
                        type="number"
                        name="min_order"
                        value="{{ old('min_order', 1) }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Default: 1"
                    >
                </div>
            </div>
        </div>

        {{-- ============== PENGIRIMAN ============== --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-400 to-rose-500 flex items-center justify-center">
                    <i class="fas fa-truck-moving text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Pengiriman</h2>
                    <p class="text-sm text-gray-500">
                        Data berat, dimensi, pre-order, dan kondisi produk untuk perhitungan ongkir.
                    </p>
                </div>
            </div>

            {{-- Baris 1: Berat & Dimensi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                {{-- Berat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Berat Produk (gram) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="weight"
                            value="{{ old('weight') }}"
                            class="w-full rounded-xl border border-gray-300 bg-white
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                   text-sm px-3 py-2.5 transition"
                            placeholder="Contoh: 500"
                        >
                        <span class="absolute inset-y-0 right-3 flex items-center text-xs text-gray-500">gram</span>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Isi berat bersih + perkiraan kemasan produk.
                    </p>
                </div>

                {{-- Dimensi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Dimensi Produk (Opsional)
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <input
                                type="number"
                                name="length"
                                value="{{ old('length') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                       text-sm px-3 py-2.5 transition"
                                placeholder="P"
                            >
                            <p class="mt-1 text-[11px] text-gray-400">Panjang (cm)</p>
                        </div>
                        <div>
                            <input
                                type="number"
                                name="width"
                                value="{{ old('width') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                       text-sm px-3 py-2.5 transition"
                                placeholder="L"
                            >
                            <p class="mt-1 text-[11px] text-gray-400">Lebar (cm)</p>
                        </div>
                        <div>
                            <input
                                type="number"
                                name="height"
                                value="{{ old('height') }}"
                                class="w-full rounded-xl border border-gray-300 bg-white
                                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                       text-sm px-3 py-2.5 transition"
                                placeholder="T"
                            >
                            <p class="mt-1 text-[11px] text-gray-400">Tinggi (cm)</p>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Dimensi membantu kurir menghitung ongkir lebih akurat (opsional, tapi disarankan).
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-100 mt-2 mb-4"></div>

            {{-- Baris 2: Pre-order & Kondisi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Pre-order switch --}}
                <div>
                    <div id="preorder-toggle-wrapper"
                         class="flex items-center justify-between mb-2 cursor-pointer select-none">
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar-check text-gray-500 text-lg"></i>
                            <span class="text-sm font-medium text-gray-800">Pre-order</span>
                            <span class="flex items-center justify-center w-4 h-4 text-[10px] text-gray-500 border border-gray-300 rounded-full">?</span>
                        </div>

                        <div class="inline-flex items-center">
                            <input
                                type="checkbox"
                                id="preorder-toggle"
                                class="hidden"
                                @if(old('preorder')) checked @endif
                            >
                            <div
                                id="preorder-track"
                                class="w-11 h-6 rounded-full flex items-center px-1 transition-all duration-200
                                       {{ old('preorder') ? 'bg-blue-500 justify-end' : 'bg-gray-300 justify-start' }}">
                                <div class="w-4 h-4 bg-white rounded-full shadow-md transition-all duration-200"></div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="preorder" id="preorder-value" value="{{ old('preorder', 0) }}">

                    <p class="text-xs text-gray-400">
                        Aktifkan jika produk membutuhkan waktu pengerjaan sebelum dikirim.
                    </p>

                    <div id="po-days" class="mt-3 {{ old('preorder') ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Lama Pre-order (hari)
                        </label>
                        <input
                            type="number"
                            name="preorder_days"
                            value="{{ old('preorder_days') }}"
                            class="w-full rounded-xl border border-gray-300 bg-white
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                   text-sm px-3 py-2.5 transition"
                            placeholder="Contoh: 3"
                        >
                        <p class="mt-1 text-xs text-gray-400">
                            Masukkan estimasi waktu pengerjaan sebelum barang dikirim.
                        </p>
                    </div>
                </div>

                {{-- Kondisi Produk --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kondisi Produk <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="condition"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                    >
                        <option value="">Pilih kondisi</option>
                        <option value="new"  {{ old('condition') == 'new'  ? 'selected' : '' }}>Baru</option>
                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Pernah Dipakai</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-400">
                        Pilih kondisi sesuai keadaan produk yang dijual.
                    </p>
                </div>
            </div>
        </div>

        {{-- ============== BUTTON AKSI ============== --}}
        <div class="flex items-center justify-end gap-3">
            <a
                href="{{ route('seller.products.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                name="submit_type"
                value="draft"
                class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 hover:bg-indigo-100"
            >
                Simpan sebagai Draft
            </button>

            <button
                type="submit"
                name="submit_type"
                value="publish"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:brightness-110 transition"
            >
                <i class="fas fa-check mr-2"></i> Terbitkan Produk
            </button>
        </div>
    </form>
@endsection
