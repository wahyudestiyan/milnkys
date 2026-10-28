
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Gudang</title>
   
<style>
:root {
    --primary: {{ $themeColors['primary'] }};
    --primary-dark: {{ $themeColors['primary_dark'] }};
    --text: {{ $themeColors['text'] }};
    --muted: {{ $themeColors['muted'] }};
    --border: {{ $themeColors['border'] }};
    --primary-soft: {{ $themeColors['primary_soft'] }};
}

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
        color: var(--text);
        background: var(--surface);
    }

    h1 {
        font-size: 20px;
        margin-bottom: 5px;
        color: var(--text);
    }

    h2 {
        font-size: 13px;
        margin-top: 22px;
        color: var(--primary-dark);
    }

    .muted {
        color: var(--muted);
    }

    .summary {
        width: 100%;
        margin: 16px 0;
        border-collapse: collapse;
    }

    .summary td {
        border: 1px solid var(--border);
        padding: 10px;
        width: 25%;
        background: var(--surface);
        color: var(--text);
    }

    .summary strong {
        color: var(--primary-dark);
    }

    table.data {
        width: 100%;
        border-collapse: collapse;
    }

    table.data th,
    table.data td {
        border: 1px solid var(--border);
        padding: 6px;
        text-align: left;
    }

    table.data th {
        background: var(--primary-soft);
        color: var(--text);
        font-weight: bold;
    }

    table.data td {
        background: var(--surface);
        color: var(--text);
    }

    .right {
        text-align: right !important;
    }
</style>

</head>
<body>
    <h1>Laporan Operasional Gudang</h1>
    <p class="muted">
        Periode {{ $tanggalAwal }} sampai {{ $tanggalAkhir }}
    </p>

    <table class="summary">
        <tr>
            <td>
                <strong>Total Fee Gudang</strong><br>
                ¥{{ number_format($totalFeeJpy, 2) }}
            </td>
            <td>
                <strong>Estimasi Rupiah</strong><br>
                @if ($totalRupiah !== null)
                    Rp{{ number_format($totalRupiah, 0, ',', '.') }}
                @else
                    Kurs belum tersedia
                @endif
            </td>
            <td>
                <strong>Total Pesanan</strong><br>
                {{ $totalPesanan }}
            </td>
            <td>
                <strong>Total Resi</strong><br>
                {{ $totalResi }}<br>
                <strong>Batch:</strong> {{ $totalBatch }}
            </td>
        </tr>
    </table>

    @if ($kurs !== null)
        <p class="muted">
            Kurs yang digunakan: ¥1 = Rp{{ number_format($kurs, 2, ',', '.') }}
        </p>
    @endif

    <h2>Detail Pesanan</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Tanggal Input</th>
                <th>Nomor Pesanan</th>
                <th>Pelanggan</th>
                <th class="right">Fee (JPY)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $item)
                <tr>
                    <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $item->order_number ?? '-' }}</td>
                    <td>{{ $item->customer_name ?? '-' }}</td>
                    <td class="right">
                        ¥{{ number_format((float) $item->warehouse_fee_jpy, 2) }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada data pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detail Resi / Barang Tiba</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Tanggal Input</th>
                <th>Nomor Resi</th>
                <th>Tanggal Barang Tiba</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resi as $item)
                <tr>
                    <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $item->tracking_number ?? '-' }}</td>
                    <td>{{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data resi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Detail Batch Pengiriman</h2>
    <table class="data">
        <thead>
            <tr>
                <th>Tanggal Dibuat</th>
                <th>Nama Batch</th>
                <th>Status</th>
                <th>Tanggal Ditutup</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($batch as $item)
                <tr>
                    <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $item->name ?? '-' }}</td>
                    <td>{{ $item->is_closed ? 'Ditutup' : 'Berjalan' }}</td>
                    <td>{{ $item->closed_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada data batch.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
