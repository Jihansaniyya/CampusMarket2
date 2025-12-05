<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * {
            font-family: 'Segoe UI', 'Helvetica', Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 24px;
            font-size: 12px;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 6px;
            background: #f8fafc;
        }

        td {
            padding: 8px 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        h1 {
            margin: 0;
            font-size: 20px;
        }

        h2 {
            margin: 0;
            font-size: 14px;
            color: #4b5563;
        }

        .meta {
            font-size: 11px;
            color: #6b7280;
        }

        .stat-box {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 12px;
            background: #f1f5f9;
            margin-top: 12px;
            margin-right: 10px;
        }

        .stat-box strong {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ $title }}</h1>
        <p class="meta">Dibuat pada: {{ $generatedAt->format('d M Y H:i') }} WIB</p>
        <div>
            <span class="stat-box">Rata-rata rating <strong>{{ number_format($averageRating, 2) }}</strong></span>
            <span class="stat-box">Total ulasan <strong>{{ $totalReviews }}</strong></span>
        </div>
    </header>

    <table>
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Produk</th>
                <th>Toko</th>
                <th>Kategori</th>
                <th>Provinsi</th>
                <th>Harga</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ optional($product->seller)->store_name ?? optional($product->seller)->name ?? '-' }}</td>
                    <td>{{ optional($product->category)->name ?? '-' }}</td>
                    <td>{{ optional($product->seller)->provinsi ?? '-' }}</td>
                    <td>Rp {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->rating, 2) }} ({{ $product->rating_count }} ulasan)</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
