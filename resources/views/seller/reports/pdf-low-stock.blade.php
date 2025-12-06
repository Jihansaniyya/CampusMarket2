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

        .meta {
            font-size: 11px;
            color: #6b7280;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <h1>{{ $title }}</h1>
    <p class="meta">Dibuat pada: {{ $generatedAt->format('d M Y H:i') }} WIB</p>
    <p class="meta">
        Keterangan: Menampilkan produk dengan stok kurang dari 2 sebagai stok kritis yang perlu segera dipesan.
    </p>
</header>

<table>
    <thead>
    <tr>
        <th style="width: 35px;">No</th>
        <th>Nama Produk</th>
        <th style="width: 20%;">Kategori</th>
        <th style="width: 10%;" class="text-right">Stok</th>
        <th style="width: 12%;" class="text-right">Rating</th>
        <th style="width: 18%;" class="text-right">Harga</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($products as $index => $product)
        @php
            $kategori = null;

            if (isset($product->category) && is_object($product->category)) {
                $kategori = $product->category->name ?? null;
            } elseif (isset($product->category) && !is_object($product->category)) {
                $kategori = $product->category;
            } elseif (isset($product->category_name)) {
                $kategori = $product->category_name;
            }
        @endphp
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $product->name ?? '-' }}</td>
            <td>{{ $kategori ?? '-' }}</td>
            <td class="text-right">{{ $product->stock ?? 0 }}</td>
            <td class="text-right">{{ number_format($product->avg_rating ?? 0, 2) }}</td>
            <td class="text-right">
                Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data produk.</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
