@extends('layouts.seller')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-description')
    Perbarui informasi produk Anda.
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('thumbnails');
            const previewContainer = document.getElementById('preview');
            const existingImagesContainer = document.getElementById('existing-images');
            const removeExistingInputs = document.getElementById('remove-existing-inputs');
            const maxFileSize = 2 * 1024 * 1024;
            let selectedFiles = [];

            if (!input || !previewContainer) return;

            function syncInputFiles() {
                const transfer = new DataTransfer();
                selectedFiles.forEach(file => transfer.items.add(file));
                input.files = transfer.files;
            }

            function renderPreview() {
                previewContainer.innerHTML = '';

                selectedFiles.forEach((file, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative w-40 h-40 rounded-xl border overflow-hidden';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'w-full h-full object-cover';

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className =
                        'absolute top-2 right-2 w-7 h-7 rounded-full bg-black/70 hover:bg-black text-white text-sm flex items-center justify-center';
                    removeButton.innerHTML = '&times;';
                    removeButton.addEventListener('click', function() {
                        selectedFiles.splice(index, 1);
                        syncInputFiles();
                        renderPreview();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeButton);
                    previewContainer.appendChild(wrapper);
                });
            }

            input.addEventListener('change', function() {
                if (input.files && input.files.length > 0) {
                    const oversizedFile = Array.from(input.files).find(file => file.size > maxFileSize);
                    if (oversizedFile) {
                        alert('Ukuran foto lebih dari 2MB. Maksimal 2MB per foto.');
                        input.value = '';
                        return;
                    }

                    selectedFiles = selectedFiles.concat(Array.from(input.files));
                    syncInputFiles();
                    renderPreview();
                }
            });

            if (existingImagesContainer && removeExistingInputs) {
                existingImagesContainer.addEventListener('click', function(event) {
                    const button = event.target.closest('[data-remove-existing]');
                    if (!button) return;

                    const imageId = button.getAttribute('data-remove-existing');
                    const card = button.closest('[data-existing-card]');

                    if (card) {
                        card.remove();
                    }

                    if (!removeExistingInputs.querySelector(`input[value="${imageId}"]`)) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'remove_existing_images[]';
                        hiddenInput.value = imageId;
                        removeExistingInputs.appendChild(hiddenInput);
                    }
                });
            }
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

    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        @method('PUT')
        <div id="remove-existing-inputs"></div>

        {{-- ================= FOTO PRODUK ================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="w-10 h-10 rounded-xl bg-linear-to-br from-purple-500 to-violet-600 flex items-center justify-center">
                    <i class="fas fa-images text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Foto Produk</h2>
                    <p class="text-sm text-gray-500">Update foto produk jika diperlukan (bisa pilih lebih dari 1)</p>
                    <p class="text-xs text-gray-400">Maksimal 2MB per foto (JPG/PNG)</p>
                </div>
            </div>

            {{-- Foto Saat Ini --}}
            @if ($product->images->count() > 0)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Foto Saat Ini:</p>
                    <div id="existing-images" class="flex flex-wrap gap-3">
                        @foreach ($product->images as $image)
                            <div class="relative w-40 h-40 rounded-xl border overflow-hidden" data-existing-card>
                                <img src="{{ asset('storage/' . $image->path) }}" alt="Current Product Image"
                                    class="w-full h-full object-cover">
                                <button type="button" data-remove-existing="{{ $image->id }}"
                                    class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/70 hover:bg-black text-white text-sm flex items-center justify-center">&times;</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif ($product->thumbnail)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Current Product"
                        class="w-40 h-40 object-cover rounded-xl border">
                </div>
            @endif

            {{-- TILE TAMBAH FOTO --}}
            <label for="thumbnails"
                class="w-40 h-40 border-2 border-dashed border-red-300 rounded-xl flex flex-col items-center justify-center text-red-500 cursor-pointer hover:bg-red-50 transition">
                <span class="text-2xl font-bold">+</span>
                <span class="text-sm font-semibold">Tambah Foto</span>
            </label>

            <input type="file" id="thumbnails" name="thumbnails[]" accept="image/*" multiple class="hidden">

            {{-- PREVIEW --}}
            <div id="preview" class="mt-3 flex flex-wrap gap-3"></div>
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
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
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                               text-sm px-3 py-2.5 transition">{{ old('description', $product->description) }}</textarea>
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
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
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
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 50">
                </div>

                {{-- Harga Diskon / Sale (opsional) --}}
                <div class="md:col-span-2 mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga Sale (Rp) <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                        class="w-full rounded-xl border border-gray-300 bg-white
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                               text-sm px-3 py-2.5 transition"
                        placeholder="Contoh: 120000">
                    <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ada harga promo.</p>
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
                <i class="fas fa-check mr-2"></i> Update Produk
            </button>
        </div>
    </form>
@endsection
