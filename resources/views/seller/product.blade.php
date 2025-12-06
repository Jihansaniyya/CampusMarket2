@extends('layouts.seller')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')
@section('page-description')
    Lengkapi detail produk anda agar mudah ditemukan.
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('preorder-toggle-wrapper');
            const checkbox = document.getElementById('preorder-toggle');
            const hiddenInput = document.getElementById('preorder-value');
            const poDays = document.getElementById('po-days');
            const track = document.getElementById('preorder-track');

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

            wrapper.addEventListener('click', function(e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
                syncPreorderUI();
            });

            syncPreorderUI();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('thumbnail');
            const previewContainer = document.getElementById('preview');

            input.addEventListener('change', function() {
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
                <div
                    class="w-10 h-10 rounded-xl bg-linear-to-br from-purple-500 to-violet-600 flex items-center justify-center">
                    <i class="fas fa-images text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Foto Produk <span class="text-red-500">*</span></h2>
                    <p class="text-sm text-gray-500">Minimal 1 foto utama</p>
                </div>
            </div>

            {{-- TILE TAMBAH FOTO --}}
            <label for="thumbnail"
                class="w-40 h-40 border-2 border-dashed border-red-300 rounded-xl flex flex-col items-center justify-center text-red-500 cursor-pointer hover:bg-red-50 transition">
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
                <div
                    class="w-10 h-10 rounded-xl bg-linear-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                    <i class="fas fa-box-open text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Informasi Produk</h2>
                    <p class="text-sm text-gray-500">Nama, kategori, dan deskripsi produk.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Produk --}}
                {{-- Nama Produk --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Charger Aki Motor 12V Otomatis"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition" />
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori Utama <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Produk <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="5" placeholder="Tulis deskripsi produk..."
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ============== HARGA & STOK ============== --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-10 h-10 rounded-xl bg-linear-to-br from-emerald-400 to-green-500 flex items-center justify-center">
                    <i class="fas fa-tags text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Harga & Stok</h2>
                    <p class="text-sm text-gray-500">Atur harga jual, stok, dan minimal pembelian.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 150000">
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock') }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 50">
                </div>
            </div>
        </div>

        {{-- ============== BUTTON AKSI ============== --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('seller.products.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit" name="submit_type" value="draft"
                class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 hover:bg-indigo-100">
                Simpan sebagai Draft
            </button>

            <button type="submit" name="submit_type" value="publish"
                class="inline-flex items-center justify-center rounded-xl bg-linear-to-r from-blue-600 via-indigo-600 to-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:brightness-110 transition">
                <i class="fas fa-check mr-2"></i> Terbitkan Produk
            </button>
        </div>
    </form>
@endsection
