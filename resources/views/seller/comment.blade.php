@extends('layouts.seller')

@section('title', 'Kelola Komentar')
@section('page-title', 'Kelola Komentar')
@section('page-description')
    Lihat dan kelola komentar yang diberikan pengunjung pada produk Anda.
@endsection

@section('content')

{{-- ===================== HEADER ===================== --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">

    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
            <i class="fas fa-comments text-white"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daftar Komentar Pengunjung</h2>
            <p class="text-sm text-gray-500">Lihat komentar dan rating pada produk Anda.</p>
        </div>
    </div>

</div>

{{-- ===================== JIKA BELUM ADA KOMENTAR ===================== --}}
@if($comments->count() == 0)

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center">
    <div class="flex justify-center mb-4">
        <i class="fas fa-comment-dots text-gray-400 text-6xl"></i>
    </div>

    <h3 class="text-xl font-semibold text-gray-700">Belum ada komentar</h3>
    <p class="text-gray-500">Komentar akan muncul ketika pengunjung memberikan feedback.</p>
</div>

@else

{{-- ===================== LIST KOMENTAR ===================== --}}
<div class="space-y-4">

@foreach ($comments as $c)

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex justify-between items-start">

        {{-- INFO KOMENTAR --}}
        <div class="flex-1">

            {{-- Nama Produk --}}
            <h3 class="text-lg font-bold text-gray-900">
                {{ $c->product->name ?? 'Produk tidak ditemukan' }}
            </h3>

            {{-- Rating (optional, jika pengunjung memberi rating) --}}
            <div class="flex items-center gap-1 mt-1">
                @for ($i=1; $i<=5; $i++)
                    <i class="fas fa-star {{ $i <= $c->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                @endfor
            </div>

            {{-- Nama Pengunjung --}}
            <p class="text-gray-600 mt-3 text-sm">
                Pengunjung: <span class="font-semibold">{{ $c->visitor_name }}</span>
            </p>

            {{-- Isi Komentar --}}
            <p class="text-gray-800 text-sm mt-2">
                “{{ $c->comment ?? 'Tidak ada komentar.' }}”
            </p>

            {{-- Email & No HP --}}
            <p class="text-gray-500 text-xs mt-2">
                Email: {{ $c->visitor_email }} • HP: {{ $c->visitor_phone }}
            </p>

            {{-- Tanggal --}}
            <p class="text-gray-500 text-xs mt-1">
                Tanggal: {{ $c->created_at->format('d M Y, H:i') }}
            </p>

        </div>

    </div>

@endforeach

</div>

@endif

@endsection
