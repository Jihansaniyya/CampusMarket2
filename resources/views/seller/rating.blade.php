@extends('layouts.seller')

@section('title', 'Kelola Rating')
@section('page-title', 'Kelola Rating')
@section('page-description')
    Lihat dan kelola semua rating & ulasan pembeli pada produk Anda.
@endsection

@section('content')

{{-- ===================== FILTER BAR ===================== --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">

    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center">
            <i class="fas fa-star text-white"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daftar Rating Produk</h2>
            <p class="text-sm text-gray-500">Lihat semua ulasan pembeli untuk produk Anda.</p>
        </div>
    </div>

</div>


{{-- ===================== JIKA TIDAK ADA REVIEW ===================== --}}
@if($reviews->count() == 0)

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center">
    <div class="flex justify-center mb-4">
        <i class="fas fa-comments text-gray-400 text-6xl"></i>
    </div>

    <h3 class="text-xl font-semibold text-gray-700">Belum ada rating</h3>
    <p class="text-gray-500">Rating akan muncul setelah pengunjung memberikan ulasan pada produk Anda.</p>
</div>

@else


{{-- ===================== LIST REVIEW ===================== --}}
<div class="space-y-4">

@foreach ($reviews as $r)

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex justify-between items-start">

        {{-- INFO RATING --}}
        <div class="flex-1">

            {{-- Nama Produk --}}
            <h3 class="text-lg font-bold text-gray-900">
                {{ $r->product->name ?? 'Produk tidak ditemukan' }}
            </h3>

            {{-- Bintang --}}
            <div class="flex items-center gap-1 mt-1">
                @for ($i=1; $i<=5; $i++)
                    <i class="fas fa-star {{ $i <= $r->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                @endfor
            </div>

            {{-- Nama Pembeli --}}
            <p class="text-gray-600 mt-3 text-sm">
                Pembeli: <span class="font-semibold">{{ $r->buyer_name ?? 'Anonymous' }}</span>
            </p>

            {{-- Komentar --}}
            <p class="text-gray-700 text-sm mt-2 italic">
                “{{ $r->comment ?? 'Tidak ada komentar.' }}”
            </p>

            {{-- Tanggal --}}
            <p class="text-gray-500 text-xs mt-1">
                Tanggal: {{ $r->created_at->format('d M Y, H:i') }}
            </p>
        </div>

    </div>

@endforeach
</div>

@endif

@endsection
