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
            margin-top: 10px;
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

        .province-title {
            margin-top: 22px;
            font-size: 14px;
            font-weight: 600;
        }

        .meta {
            font-size: 11px;
            color: #6b7280;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 999px;
            background: #eef2ff;
            color: #4338ca;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ $title }}</h1>
        <h2>{{ $subtitle }}</h2>
        <p class="meta">Dibuat pada: {{ $generatedAt->format('d M Y H:i') }} WIB</p>
    </header>

    @forelse ($sellers as $province => $items)
        <h3 class="province-title">
            {{ $province }}
            <span class="chip">{{ $items->count() }} toko</span>
        </h3>
        <table>
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>Nama Toko</th>
                    <th>PIC</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $seller)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seller->store_name ?? '-' }}</td>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->phone ?? '-' }}</td>
                        <td>{{ ucfirst($seller->approval_status ?? 'pending') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>Tidak ada data penjual dengan informasi provinsi.</p>
    @endforelse
</body>

</html>
