
<table>
    <tr>
        <th colspan="4">LAPORAN OPERASIONAL GUDANG</th>
    </tr>
    <tr>
        <td colspan="4">
            Periode: {{ $tanggalAwal }} sampai {{ $tanggalAkhir }}
        </td>
    </tr>
    <tr><td colspan="4"></td></tr>

    <tr>
        <th>Total Fee Gudang (JPY)</th>
        <th>Estimasi Rupiah</th>
        <th>Total Pesanan</th>
        <th>Total Resi</th>
    </tr>
    <tr>
        <td>{{ $totalFeeJpy }}</td>
        <td>{{ $totalRupiah ?? 'Kurs belum tersedia' }}</td>
        <td>{{ $totalPesanan }}</td>
        <td>{{ $totalResi }}</td>
    </tr>
    <tr>
        <td colspan="4">
            Kurs JPY ke IDR:
            {{ $kurs !== null ? $kurs : 'Belum tersedia' }}
        </td>
    </tr>

    <tr><td colspan="4"></td></tr>
    <tr><th colspan="4">DETAIL PESANAN</th></tr>
    <tr>
        <th>Tanggal Input</th>
        <th>Nomor Pesanan</th>
        <th>Pelanggan</th>
        <th>Fee (JPY)</th>
    </tr>
    @forelse ($pesanan as $item)
        <tr>
            <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
            <td>{{ $item->order_number ?? '-' }}</td>
            <td>{{ $item->customer_name ?? '-' }}</td>
            <td>{{ (float) $item->warehouse_fee_jpy }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Tidak ada data pesanan</td></tr>
    @endforelse

    <tr><td colspan="4"></td></tr>
    <tr><th colspan="4">DETAIL RESI / BARANG TIBA</th></tr>
    <tr>
        <th>Tanggal Input</th>
        <th>Nomor Resi</th>
        <th colspan="2">Tanggal Barang Tiba</th>
    </tr>
    @forelse ($resi as $item)
        <tr>
            <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
            <td>{{ $item->tracking_number ?? '-' }}</td>
            <td colspan="2">{{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Tidak ada data resi</td></tr>
    @endforelse

    <tr><td colspan="4"></td></tr>
    <tr><th colspan="4">DETAIL BATCH PENGIRIMAN</th></tr>
    <tr>
        <th>Tanggal Dibuat</th>
        <th>Nama Batch</th>
        <th>Status</th>
        <th>Tanggal Ditutup</th>
    </tr>
    @forelse ($batch as $item)
        <tr>
            <td>{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
            <td>{{ $item->name ?? '-' }}</td>
            <td>{{ $item->is_closed ? 'Ditutup' : 'Berjalan' }}</td>
            <td>{{ $item->closed_at?->format('d/m/Y H:i') ?? '-' }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Tidak ada data batch</td></tr>
    @endforelse
</table>
