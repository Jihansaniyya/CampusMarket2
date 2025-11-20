@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')
@section('page-description')
    Selamat datang, {{ Auth::user()->name }}! 👋
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#2563eb', '#7c3aed', '#f97316', '#059669', '#ec4899', '#f59e0b'];

        const productCategoryData = @json($productCategoryStats->values());
        const sellerProvinceData = @json($sellerProvinceStats->values());
        const sellerActivityData = @json($sellerActivityStats);
        const visitorEngagementData = @json($visitorEngagementStats['monthly']);

        const renderChart = (id, config) => {
            const canvas = document.getElementById(id);
            if (!canvas || typeof Chart === 'undefined') {
                return;
            }
            return new Chart(canvas.getContext('2d'), config);
        };

        if (productCategoryData.length) {
            renderChart('productCategoryChart', {
                type: 'doughnut',
                data: {
                    labels: productCategoryData.map(item => item.label),
                    datasets: [{
                        data: productCategoryData.map(item => item.value),
                        backgroundColor: palette,
                        borderWidth: 0,
                    }],
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                    },
                    cutout: '65%',
                },
            });
        }

        if (sellerProvinceData.length) {
            renderChart('sellerProvinceChart', {
                type: 'bar',
                data: {
                    labels: sellerProvinceData.map(item => item.label),
                    datasets: [{
                        label: 'Jumlah Toko',
                        data: sellerProvinceData.map(item => item.value),
                        backgroundColor: '#2563eb',
                        borderRadius: 8,
                    }],
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 },
                            grid: { color: '#f1f5f9' },
                        },
                        x: {
                            grid: { display: false },
                        },
                    },
                },
            });
        }

        renderChart('sellerActivityChart', {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Tidak Aktif'],
                datasets: [{
                    data: [sellerActivityData.active, sellerActivityData.inactive],
                    backgroundColor: ['#059669', '#f43f5e'],
                    borderWidth: 0,
                }],
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    },
                },
                cutout: '70%',
            },
        });

        if (visitorEngagementData.length) {
            renderChart('visitorEngagementChart', {
                type: 'line',
                data: {
                    labels: visitorEngagementData.map(item => item.label),
                    datasets: [{
                        label: 'Pengunjung Aktif',
                        data: visitorEngagementData.map(item => item.value),
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124, 58, 237, 0.15)',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: true,
                    }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });
        }
    </script>
@endpush

@section('content')
    @php
        $hasProductCategoryData = $productCategoryStats->isNotEmpty();
        $hasSellerProvinceData = $sellerProvinceStats->isNotEmpty();
        $hasVisitorChartData = count($visitorEngagementStats['monthly']) > 0;
        $hasVisitorBreakdown = count($visitorEngagementStats['rating_breakdown']) > 0;
    @endphp

    <div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Pending Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-amber-400 to-orange-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-3xl"></i>
                        </div>
                        @if ($pendingSellersCount > 0)
                            <span class="px-3 py-1 bg-white/30 backdrop-blur-sm rounded-full text-xs font-bold">Perlu
                                Aksi</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Menunggu Persetujuan</p>
                    <p class="text-4xl font-bold mb-4">{{ $pendingSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Approved Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-emerald-400 to-teal-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Penjual Disetujui</p>
                    <p class="text-4xl font-bold mb-4">{{ $approvedSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Rejected Sellers --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-rose-400 to-pink-500"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-times-circle text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Penjual Ditolak</p>
                    <p class="text-4xl font-bold mb-4">{{ $rejectedSellersCount }}</p>
                    <a href="{{ route('admin.sellers.approval.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            {{-- Total Users --}}
            <div
                class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="absolute inset-0 bg-linear-to-br from-blue-500 to-indigo-600"></div>
                <div class="absolute inset-0 bg-black opacity-5"></div>
                <div class="relative p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-3xl"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium mb-1 opacity-90">Total Users</p>
                    <p class="text-4xl font-bold mb-4">{{ $totalUsers }}</p>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center text-sm font-semibold hover:gap-3 transition-all">
                        Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Insight & Reports (SRS-MartPlace-07) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Produk per Kategori --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Sebaran Produk per Kategori</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $productCategoryStats->sum('value') }}</p>
                        <p class="text-xs text-gray-400">Jumlah total produk aktif</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">SRS-07</span>
                </div>
                @if ($hasProductCategoryData)
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="flex-1">
                            <canvas id="productCategoryChart" height="240"></canvas>
                        </div>
                        <div class="flex-1 space-y-3">
                            @foreach ($productCategoryStats as $stat)
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-600">{{ $stat['label'] }}</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-gray-50 rounded-2xl text-center border border-dashed border-gray-200">
                        <p class="text-gray-600 font-semibold">Belum ada data produk.</p>
                        <p class="text-sm text-gray-500 mt-1">Tambahkan produk dari penjual untuk melihat grafik secara
                            realtime.</p>
                    </div>
                @endif
            </div>

            {{-- Toko per Provinsi --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Sebaran Toko per Provinsi</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $sellerProvinceStats->sum('value') }}</p>
                        <p class="text-xs text-gray-400">Total penjual terdaftar</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">SRS-07</span>
                </div>
                @if ($hasSellerProvinceData)
                    <div>
                        <canvas id="sellerProvinceChart" height="240"></canvas>
                    </div>
                @else
                    <div class="p-6 bg-gray-50 rounded-2xl text-center border border-dashed border-gray-200">
                        <p class="text-gray-600 font-semibold">Belum ada data lokasi penjual.</p>
                        <p class="text-sm text-gray-500 mt-1">Penjual perlu mengisi provinsi agar grafik muncul.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Aktivitas Penjual --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Status Penjual (Aktif vs Tidak Aktif)</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $sellerActivityStats['active'] + $sellerActivityStats['inactive'] }}</p>
                        <p class="text-xs text-gray-400">Mengacu pada persetujuan akun</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">SRS-09</span>
                </div>
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <canvas id="sellerActivityChart" height="220"></canvas>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Aktif</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ $sellerActivityStats['active'] }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Tidak Aktif</p>
                            <p class="text-2xl font-bold text-rose-500">{{ $sellerActivityStats['inactive'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Engagement Pengunjung --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Komentar & Rating Pengunjung</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $visitorEngagementStats['total_reviews'] }}</p>
                        <p class="text-xs text-gray-400">Pengunjung yang meninggalkan feedback</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold bg-blue-50 text-blue-600 rounded-full">SRS-11</span>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2">
                        @if ($hasVisitorChartData)
                            <canvas id="visitorEngagementChart" height="220"></canvas>
                        @else
                            <div
                                class="h-full min-h-[220px] rounded-2xl border border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center p-6 text-center">
                                <p class="text-gray-600 font-semibold">Belum ada komentar atau rating.</p>
                                <p class="text-sm text-gray-500 mt-1">Data akan tampil otomatis saat pengunjung meninggalkan
                                    feedback.</p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400 mb-3">Rating Breakdown</p>
                        @if ($hasVisitorBreakdown)
                            <div class="space-y-2">
                                @foreach ($visitorEngagementStats['rating_breakdown'] as $row)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">{{ $row['label'] }}★</span>
                                        <span class="font-semibold text-gray-900">{{ $row['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Belum ada data rating.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Aksi Cepat</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.sellers.approval.index') }}"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-user-check text-blue-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Persetujuan Penjual
                        </p>
                        <p class="text-sm text-gray-600">Kelola pendaftaran penjual</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-blue-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl border-2 border-emerald-100 hover:border-emerald-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-users-cog text-emerald-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">Kelola User</p>
                        <p class="text-sm text-gray-600">Manajemen semua user</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-emerald-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>

                <a href="{{ route('admin.reports.products.ratings') }}" target="_blank" rel="noopener"
                    class="relative overflow-hidden group flex items-center gap-4 p-5 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl border-2 border-violet-100 hover:border-violet-400 hover:shadow-lg transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-white shadow-md group-hover:shadow-xl rounded-xl flex items-center justify-center shrink-0 transition-all duration-300">
                        <i class="fas fa-chart-line text-violet-600 text-xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-violet-600 transition-colors">Laporan Produk</p>
                        <p class="text-sm text-gray-600">Unduh rating produk (SRS-11)</p>
                    </div>
                    <i
                        class="fas fa-arrow-right absolute right-4 text-violet-400 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2 transition-all"></i>
                </a>
            </div>
        </div>

        {{-- Download Laporan (PDF) --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-pdf text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Download Laporan Resmi</h2>
                    <p class="text-sm text-gray-500">Memenuhi kebutuhan SRS-MartPlace-09, 10, dan 11</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.reports.sellers.status') }}" target="_blank" rel="noopener"
                    class="border border-gray-200 rounded-2xl p-4 hover:border-blue-400 hover:shadow-lg transition group">
                    <p class="text-xs font-semibold text-blue-500 mb-1">SRS-09</p>
                    <p class="text-lg font-bold text-gray-900">Penjual Aktif vs Tidak Aktif</p>
                    <p class="text-sm text-gray-500 mt-2">Format PDF menampilkan status akun terbaru.</p>
                    <span class="text-sm text-blue-500 font-semibold inline-flex items-center gap-1 mt-3">Unduh sekarang
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition"></i></span>
                </a>
                <a href="{{ route('admin.reports.sellers.provinces') }}" target="_blank" rel="noopener"
                    class="border border-gray-200 rounded-2xl p-4 hover:border-emerald-400 hover:shadow-lg transition group">
                    <p class="text-xs font-semibold text-emerald-500 mb-1">SRS-10</p>
                    <p class="text-lg font-bold text-gray-900">Daftar Penjual per Provinsi</p>
                    <p class="text-sm text-gray-500 mt-2">Memetakan toko berdasarkan lokasi propinsi.</p>
                    <span class="text-sm text-emerald-500 font-semibold inline-flex items-center gap-1 mt-3">Unduh sekarang
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition"></i></span>
                </a>
                <a href="{{ route('admin.reports.products.ratings') }}" target="_blank" rel="noopener"
                    class="border border-gray-200 rounded-2xl p-4 hover:border-violet-400 hover:shadow-lg transition group">
                    <p class="text-xs font-semibold text-violet-500 mb-1">SRS-11</p>
                    <p class="text-lg font-bold text-gray-900">Produk & Rating Menurun</p>
                    <p class="text-sm text-gray-500 mt-2">Termasuk nama toko, kategori, harga, dan propinsi.</p>
                    <span class="text-sm text-violet-500 font-semibold inline-flex items-center gap-1 mt-3">Unduh sekarang
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition"></i></span>
                </a>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-10 h-10 bg-linear-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h2>
            </div>
            <div class="text-center py-12">
                <div
                    class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium">Fitur aktivitas akan segera hadir</p>
                <p class="text-sm text-gray-400 mt-1">Pantau semua aktivitas admin dan user di sini</p>
            </div>
        </div>
    </div>
@endsection
