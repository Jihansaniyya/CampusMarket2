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
            display: flex;
            align-items: center;
            gap: 8px;
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

        .chip-empty {
            background: #f3f4f6;
            color: #9ca3af;
        }

        .summary-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 16px 0;
        }

        .summary-box h3 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #166534;
        }

        .summary-stats {
            display: flex;
            gap: 24px;
        }

        .stat-item {
            font-size: 11px;
            color: #374151;
        }

        .stat-value {
            font-weight: 600;
            font-size: 16px;
            color: #166534;
        }

        .empty-province {
            color: #9ca3af;
            font-style: italic;
            padding: 8px 0;
            font-size: 11px;
        }

        .province-section {
            page-break-inside: avoid;
        }

        .status-approved {
            color: #166534;
            background: #dcfce7;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }

        .status-pending {
            color: #92400e;
            background: #fef3c7;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }

        .status-rejected {
            color: #991b1b;
            background: #fee2e2;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ $title }}</h1>
        <p class="meta">Dibuat pada: {{ $generatedAt->format('d M Y H:i') }} WIB</p>
    </header>

    <div class="summary-box">
        <h3>Ringkasan Data</h3>
        <div class="summary-stats">
            <div class="stat-item">
                <div class="stat-value">{{ $totalSellers }}</div>
                Total Penjual Terdaftar
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $provincesWithSellers }}</div>
                Provinsi dengan Penjual
            </div>
        </div>
    </div>

    {{-- Daftar Ringkasan Provinsi --}}
    <div style="margin: 20px 0; padding: 12px; background: #f8fafc; border-radius: 8px;">
        <h3 style="margin: 0 0 10px 0; font-size: 13px; color: #374151;">Ringkasan per Provinsi:</h3>
        <table style="width: 100%; font-size: 11px;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 4px 8px; border-bottom: 1px solid #e5e7eb;">Provinsi</th>
                    <th style="text-align: center; padding: 4px 8px; border-bottom: 1px solid #e5e7eb; width: 80px;">Jumlah Toko</th>
                    <th style="text-align: left; padding: 4px 8px; border-bottom: 1px solid #e5e7eb;">Nama Toko</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($provinces as $province => $items)
                    @if ($items->count() > 0)
                        <tr>
                            <td style="padding: 6px 8px; border-bottom: 1px solid #f1f5f9; font-weight: 500;">{{ $province }}</td>
                            <td style="padding: 6px 8px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 10px; font-weight: 600;">{{ $items->count() }}</span>
                            </td>
                            <td style="padding: 6px 8px; border-bottom: 1px solid #f1f5f9; color: #6b7280;">
                                {{ $items->pluck('store_name')->filter()->implode(', ') ?: '-' }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="page-break-before: always;"></div>
    <h2 style="margin-top: 0; font-size: 16px; color: #1f2937;">Detail Penjual per Provinsi</h2>

    @foreach ($provinces as $province => $items)
        @if ($items->count() > 0)
            <div class="province-section">
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
                                <td><strong>{{ $seller->store_name ?? '-' }}</strong></td>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>{{ $seller->phone ?? '-' }}</td>
                                <td>
                                    @php $status = $seller->approval_status ?? 'pending'; @endphp
                                    <span class="status-{{ $status }}">{{ ucfirst($status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach

    @if ($totalSellers == 0)
        <p style="text-align: center; color: #9ca3af; padding: 40px;">Belum ada penjual terdaftar.</p>
    @endif
</body>

</html>
