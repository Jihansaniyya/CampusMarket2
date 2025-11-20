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

        .badge {
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-active {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #b91c1c;
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

        .section-title {
            margin-top: 24px;
            font-size: 14px;
            font-weight: 600;
        }

        .meta {
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ $title }}</h1>
        <h2>{{ $subtitle }}</h2>
        <p class="meta">Dibuat pada: {{ $generatedAt->format('d M Y H:i') }} WIB</p>
    </header>

    @forelse ($sellers as $statusLabel => $items)
        <h3 class="section-title">Status: {{ $statusLabel }} ({{ $items->count() }} akun)</h3>
        <table>
            <thead>
                <tr>
                    <th style="width:30px">No</th>
                    <th>Nama Toko</th>
                    <th>PIC</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th style="width:120px">Tanggal Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $seller)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seller->store_name ?? '-' }}</td>
                        <td>
                            <strong>{{ $seller->name }}</strong><br>
                            <span class="meta">{{ $seller->email }}</span>
                        </td>
                        <td>{{ $seller->phone ?? '-' }}</td>
                        <td>
                            @php
                                $isActive = $seller->approval_status === 'approved';
                            @endphp
                            <span class="badge {{ $isActive ? 'badge-active' : 'badge-inactive' }}">
                                {{ $isActive ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            {{ optional($seller->approved_at ?? $seller->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p>Tidak ada data penjual.</p>
    @endforelse
</body>

</html>
