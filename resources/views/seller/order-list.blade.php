@extends('layouts.seller')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')
@section('page-description')
    Lihat dan kelola semua pesanan yang masuk ke toko Anda.
@endsection

@section('content')

{{-- ===================== FILTER BAR ===================== --}}
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">

    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
            <i class="fas fa-shopping-cart text-white"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">Daftar Pesanan</h2>
            <p class="text-sm text-gray-500">Filter, cari, dan kelola pesanan masuk.</p>
        </div>
    </div>

    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

        {{-- SEARCH --}}
        <div class="md:col-span-2">
            <input 
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama pembeli / ID pesanan..."
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition"
            />
        </div>

        {{-- FILTER STATUS --}}
        <div>
            <select name="status"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition">
                <option value="">Semua Status</option>
                <option value="pending"     {{ request('status')=='pending' ? 'selected':'' }}>Pending</option>
                <option value="processed"   {{ request('status')=='processed' ? 'selected':'' }}>Diproses</option>
                <option value="shipped"     {{ request('status')=='shipped' ? 'selected':'' }}>Dikirim</option>
                <option value="completed"   {{ request('status')=='completed' ? 'selected':'' }}>Selesai</option>
                <option value="cancelled"   {{ request('status')=='cancelled' ? 'selected':'' }}>Dibatalkan</option>
            </select>
        </div>

        {{-- METODE PEMBAYARAN --}}
        <div>
            <select name="payment"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition">
                <option value="">Pembayaran</option>
                <option value="cod" {{ request('payment')=='cod' ? 'selected':'' }}>COD</option>
                <option value="transfer" {{ request('payment')=='transfer' ? 'selected':'' }}>Transfer Bank</option>
                <option value="ewallet" {{ request('payment')=='ewallet' ? 'selected':'' }}>E-Wallet</option>
            </select>
        </div>

        {{-- SORT --}}
        <div>
            <select name="sort"
                class="w-full rounded-xl border border-gray-300 bg-white
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                       text-sm px-3 py-2.5 transition">
                <option value="">Urutkan: Terbaru</option>
                <option value="oldest"      {{ request('sort')=='oldest' ? 'selected':'' }}>Terlama</option>
            </select>
        </div>

        {{-- BUTTON --}}
        <div>
            <button class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2.5 rounded-xl shadow hover:brightness-110 transition text-sm font-semibold">
                Terapkan
            </button>
        </div>
    </form>
</div>


{{-- ===================== JIKA BELUM ADA PESANAN ===================== --}}
@if($orders->count() == 0)

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center">
    <div class="flex justify-center mb-4">
        <i class="fas fa-inbox text-gray-400 text-6xl"></i>
    </div>

    <h3 class="text-xl font-semibold text-gray-700">Belum ada pesanan</h3>
    <p class="text-gray-500">Pesanan akan muncul di sini ketika pembeli melakukan checkout.</p>
</div>

@else


{{-- ===================== LIST PESANAN ===================== --}}
<div class="space-y-4">

@foreach ($orders as $o)

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex justify-between items-start">

        {{-- INFO PESANAN --}}
        <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-900">
                Pesanan #{{ $o->order_code }}
            </h3>

            {{-- BADGES --}}
            <div class="flex gap-2 mt-2">

                {{-- STATUS --}}
                <span class="
                    px-3 py-1 rounded-full text-xs font-semibold
                    @if($o->status=='pending') bg-yellow-100 text-yellow-700
                    @elseif($o->status=='processed') bg-blue-100 text-blue-700
                    @elseif($o->status=='shipped') bg-indigo-100 text-indigo-700
                    @elseif($o->status=='completed') bg-green-100 text-green-700
                    @else bg-red-100 text-red-700
                    @endif
                ">
                    {{ ucfirst($o->status) }}
                </span>

                {{-- PAYMENT --}}
                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                    {{ strtoupper($o->payment_method) }}
                </span>

            </div>

            <p class="text-gray-600 mt-3 text-sm">
                Pembeli: <span class="font-semibold">{{ $o->buyer_name }}</span> •  
                Total: <span class="font-bold">Rp {{ number_format($o->total_amount) }}</span>
            </p>

            <p class="text-gray-500 text-xs mt-1">
                Tanggal: {{ $o->created_at->format('d M Y, H:i') }}
            </p>
        </div>

        {{-- ACTION --}}
        <div class="text-right">
            <a href="{{ route('seller.orders.show', $o->id) }}"
               class="text-indigo-600 hover:underline font-semibold text-sm">
                Lihat Detail
            </a>
        </div>

    </div>

@endforeach

</div>

{{-- PAGINATION --}}
<div class="mt-6">
    {{ $orders->links() }}
</div>

@endif

@endsection
