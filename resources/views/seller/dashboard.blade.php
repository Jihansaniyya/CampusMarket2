@extends('layouts.seller')

@section('title', 'Seller Dashboard')
@section('page-title', 'Dashboard Penjual')
@section('page-description')
    Halo, {{ Auth::user()->name }}! 👋 Selamat datang di <strong
        class="text-blue-600">{{ Auth::user()->store_name ?? 'Toko Anda' }}</strong>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#2563eb', '#7c3aed', '#f97316', '#059669', '#ec4899', '#f59e0b'];

        const stockData = @json($stockDistribution->values());
        const ratingData = @json($ratingDistribution->values());
        const userProvinceData = @json($ratingProvinceStats->values());

        const renderChart = (id, config) => {
            const canvas = document.getElementById(id);
            if (!canvas || typeof Chart === 'undefined') return;
            return new Chart(canvas.getContext('2d'), config);
        };

        // 1. Stok Produk
        if (stockData.length) {
            renderChart('stockChart', {
                type: 'doughnut',
                data: {
                    labels: stockData.map(i => i.label),
                    datasets: [{
                        data: stockData.map(i => i.value),
                        backgroundColor: palette,
                        borderWidth: 0,
                    }],
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    },
                    cutout: '65%',
                },
            });
        }

        // 2. Rating Produk
        if (ratingData.length) {
            renderChart('ratingChart', {
                type: 'bar',
                data: {
                    labels: ratingData.map(i => i.label),
                    datasets: [{
                        label: 'Rating',
                        data: ratingData.map(i => i.value),
                        backgroundColor: '#7c3aed',
                        borderRadius: 8,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // 3. Lokasi Pemberi Rating
        if (userProvinceData.length) {
            renderChart('ratingProvinceChart', {
                type: 'bar',
                data: {
                    labels: userProvinceData.map(i => i.label),
                    datasets: [{
                        label: 'Rating Masuk',
                        data: userProvinceData.map(i => i.value),
                        backgroundColor: '#2563eb',
                        borderRadius: 8,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush


@section('content')
    <div>

        {{-- STATISTIC CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">

            {{-- Total Produk --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-blue-500 to-indigo-600"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-box text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm opacity-90">Total Produk</p>
                    <p class="text-4xl font-bold mb-4">{{ $totalProducts }}</p>
                    <a href="{{ route('seller.products.index') }}" class="inline-flex items-center text-sm font-semibold">
                        Lihat Produk <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Rating + Komentar --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-orange-400 to-rose-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-star text-3xl"></i>
                        </div>
                    </div>

                    <p class="text-sm opacity-90">Total Rating & Komentar</p>

                    {{-- kalau mau angka gabungan pakai ini --}}
                    <p class="text-4xl font-bold mb-1">
                        {{ $totalRatings + $totalComments }}
                    </p>

                    {{-- info detail rating & komentar --}}
                    <p class="text-xs opacity-90 mb-4">
                        Rating: {{ $totalRatings }} • Komentar: {{ $totalComments }}
                    </p>

                    <a href="{{ route('seller.ratings.index') }}" class="inline-flex items-center text-sm font-semibold">
                        Lihat Rating & Komentar <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

        </div>



        {{-- CHART AREA --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            {{-- SEBARAN STOK PER PRODUK --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Sebaran Stok Produk</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stockDistribution->sum('value') }}</p>
                        <p class="text-xs text-gray-400">Total stok semua produk</p>
                    </div>
                </div>

                @if ($stockDistribution->isNotEmpty())
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <canvas id="stockChart" height="240"></canvas>
                        </div>
                        <div class="flex-1 space-y-3">
                            @foreach ($stockDistribution as $row)
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-600">{{ $row['label'] }}</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $row['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-gray-50 rounded-2xl text-center border border-dashed">
                        <p class="text-gray-600 font-semibold">Tidak ada data stok.</p>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan produk untuk menampilkan grafik.</p>
                    </div>
                @endif
            </div>

            {{-- RATING PER PRODUK --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Sebaran Rating per Produk</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $ratingDistribution->sum('value') }}</p>
                        <p class="text-xs text-gray-400">Rating dari semua produk</p>
                    </div>
                </div>

                @if ($ratingDistribution->isNotEmpty())
                    <canvas id="ratingChart" height="240"></canvas>
                @else
                    <div class="p-6 bg-gray-50 rounded-2xl text-center border border-dashed">
                        <p class="text-gray-600 font-semibold">Belum ada rating.</p>
                        <p class="text-sm text-gray-500">Rating akan muncul setelah pembeli memberi feedback.</p>
                    </div>
                @endif
            </div>

        </div>


        {{-- PROVINSI PEMBERI RATING --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-500">Asal Provinsi Pemberi Rating</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $ratingProvinceStats->sum('value') }}</p>
                    <p class="text-xs text-gray-400">Lokasi pembeli yang memberi rating</p>
                </div>
            </div>

            @if ($ratingProvinceStats->isNotEmpty())
                <canvas id="ratingProvinceChart" height="260"></canvas>
            @else
                <div class="p-6 bg-gray-50 rounded-2xl text-center border border-dashed">
                    <p class="text-gray-600 font-semibold">Belum ada data lokasi rating.</p>
                    <p class="text-sm text-gray-500">Data akan muncul setelah pembeli memberi rating.</p>
                </div>
            @endif
        </div>


        {{-- QUICK ACTIONS --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Aksi Cepat</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <a href="{{ route('seller.products.create') }}"
                    class="group relative p-5 rounded-xl border-2 bg-blue-50 hover:border-blue-400 transition">
                    <div class="w-14 h-14 bg-white shadow-md rounded-xl flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600 text-xl"></i>
                    </div>
                    <p class="mt-3 font-bold text-gray-900 group-hover:text-blue-600">Tambah Produk</p>
                    <p class="text-sm text-gray-600">Tambahkan produk baru ke tokomu.</p>
                </a>

                <a href="{{ route('seller.products.index') }}"
                    class="group relative p-5 rounded-xl border-2 bg-indigo-50 hover:border-indigo-400 transition">
                    <div class="w-14 h-14 bg-white shadow-md rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes text-indigo-600 text-xl"></i>
                    </div>
                    <p class="mt-3 font-bold text-gray-900 group-hover:text-indigo-600">Kelola Produk</p>
                    <p class="text-sm text-gray-600">Lihat & atur semua produkmu.</p>
                </a>

                <a href="{{ route('seller.orders.index') }}"
                    class="group relative p-5 rounded-xl border-2 bg-emerald-50 hover:border-emerald-400 transition">
                    <div class="w-14 h-14 bg-white shadow-md rounded-xl flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-emerald-600 text-xl"></i>
                    </div>
                    <p class="mt-3 font-bold text-gray-900 group-hover:text-emerald-600">Kelola Pesanan</p>
                    <p class="text-sm text-gray-600">Pantau pesanan pembeli.</p>
                </a>

            </div>
        </div>

    </div>
@endsection
