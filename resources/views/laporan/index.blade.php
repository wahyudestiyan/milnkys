@extends('layouts.app')

@section('content')
<style>
/* Struktur dan bentuk komponen laporan */
.report-page {
    width: 100%;
    min-width: 0;
    color: var(--text);
    background: transparent;
}

.report-page,
.report-page * {
    box-sizing: border-box;
}

.report-heading {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.report-eyebrow {
    margin-bottom: 7px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.report-title {
    margin: 0;
    font-size: clamp(25px, 3vw, 32px);
    line-height: 1.2;
    font-weight: 800;
}

.report-description {
    margin: 10px 0 0;
    font-size: 14px;
    line-height: 1.6;
}

.report-period-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
    padding: 10px 13px;
    border: 1px solid var(--border);
    border-radius: 12px;
    font-size: 12px;
    white-space: nowrap;
}

.report-card {
    min-width: 0;
    border: 1px solid var(--border);
    border-radius: 16px;
    background: var(--surface);
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
}

.report-filter {
    padding: 22px;
    margin-bottom: 22px;
}

.report-section-heading {
    margin: 0;
    font-size: 18px;
    line-height: 1.35;
    font-weight: 750;
}

.report-section-description {
    margin: 6px 0 0;
    font-size: 13px;
    line-height: 1.6;
}

.report-filter-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
    margin-top: 18px;
}

.report-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
    min-width: 0;
}

.report-field label {
    font-size: 12px;
    font-weight: 650;
}

.report-field input {
    width: 100%;
    min-width: 0;
    min-height: 42px;
    padding: 9px 11px;
    border: 1px solid var(--border);
    border-radius: 9px;
    font: inherit;
    font-size: 13px;
    outline: none;
}

.report-field input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-soft);
}

.report-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
    margin-top: 18px;
}

.report-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 40px;
    padding: 10px 14px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.2;
    text-decoration: none;
    cursor: pointer;
    transition: background .18s ease, border-color .18s ease, transform .18s ease;
}

.report-button:hover {
    transform: translateY(-1px);
}

.report-button-primary {
    color: #fff;
    background: var(--primary);
    border-color: var(--primary);
}

.report-button-primary:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
}

.report-button-pdf {
    color: var(--danger);
    background: var(--danger-soft);
    border-color: var(--danger-soft);
}

.report-button-excel {
    color: var(--success);
    background: var(--success-soft);
    border-color: var(--success-soft);
}

.report-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.report-stat {
    padding: 18px;
}

.report-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.report-stat-label {
    font-size: 12px;
    font-weight: 650;
    line-height: 1.4;
}

.report-stat-icon,
.report-table-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 11px;
    font-size: 18px;
}

.report-stat-value {
    margin-top: 15px;
    font-size: clamp(19px, 2vw, 25px);
    font-weight: 800;
    line-height: 1.25;
    overflow-wrap: anywhere;
}

.report-stat-note {
    margin-top: 7px;
    font-size: 11px;
    line-height: 1.5;
}

.report-table-card {
    overflow: hidden;
    margin-bottom: 20px;
}

.report-table-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
}

.report-table-icon {
    width: 40px;
    height: 40px;
}

.report-table-title {
    margin: 0;
    font-size: 15px;
    line-height: 1.4;
    font-weight: 750;
}

.report-table-subtitle {
    margin: 4px 0 0;
    font-size: 11px;
    line-height: 1.5;
}

.report-table-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 12px;
}

.report-table thead {
    background: var(--bg);
}

.report-table th {
    padding: 12px 16px;
    font-size: 10px;
    font-weight: 750;
    letter-spacing: .45px;
    text-transform: uppercase;
    white-space: nowrap;
}

.report-table td {
    padding: 13px 16px;
    border-top: 1px solid var(--border);
    vertical-align: middle;
    line-height: 1.5;
}

.report-table tbody tr:hover {
    background: var(--bg);
}

.report-primary-cell {
    font-weight: 700;
}

.report-date {
    white-space: nowrap;
    font-size: 11px;
}

.report-table .text-right {
    text-align: right;
    white-space: nowrap;
}

.report-status {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.report-status-closed {
    color: var(--success);
    background: var(--success-soft);
}

.report-status-open {
    color: var(--warning);
    background: color-mix(in srgb, var(--warning) 12%, var(--surface));
}

.report-empty {
    padding: 25px 16px !important;
    text-align: center;
    font-size: 12px;
}

.report-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
    padding: 14px 18px;
    border-top: 1px solid var(--border);
    font-size: 12px;
}

.report-footer strong {
    color: var(--text);
}

/* Warna seluruh elemen mengikuti variabel tema layouts.app */
.report-eyebrow,
.report-table-icon,
.report-stat-icon {
    color: var(--primary);
}

.report-title,
.report-section-heading,
.report-table-title,
.report-primary-cell,
.report-stat-value,
.report-footer strong {
    color: var(--text);
}

.report-description,
.report-section-description,
.report-table-subtitle,
.report-stat-label,
.report-stat-note,
.report-date,
.report-footer {
    color: var(--muted);
}

.report-period-label,
.report-card {
    color: var(--text);
    background: var(--surface);
    border-color: var(--border);
}

.report-stat-icon,
.report-table-icon {
    background: var(--primary-soft);
}

.report-field label {
    color: var(--text);
}

.report-field input {
    color: var(--text);
    background: var(--bg);
    border-color: var(--border);
}

.report-button-primary {
    color: #fff;
    background: var(--primary);
    border-color: var(--primary);
}

.report-button-primary:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
}

.report-button-pdf {
    color: var(--danger);
    background: var(--danger-soft);
    border-color: var(--danger-soft);
}

.report-button-excel {
    color: var(--success);
    background: var(--success-soft);
    border-color: var(--success-soft);
}

.report-table-heading,
.report-table td,
.report-footer {
    border-color: var(--border);
}

.report-table {
    color: var(--text);
}

.report-table thead {
    background: var(--bg);
}

.report-table th {
    color: var(--muted);
}

.report-table tbody tr:hover {
    background: var(--bg);
}

.report-empty {
    color: var(--muted) !important;
}

@media (max-width: 900px) {
    .report-summary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {
    .report-heading {
        flex-direction: column;
        gap: 12px;
        margin-bottom: 18px;
    }

    .report-period-label {
        max-width: 100%;
        white-space: normal;
    }

    .report-filter {
        padding: 16px;
        margin-bottom: 16px;
    }

    .report-filter-grid {
        grid-template-columns: minmax(0, 1fr);
        gap: 12px;
    }

    .report-actions {
        align-items: stretch;
        flex-direction: column;
    }

    .report-button {
        width: 100%;
    }

    .report-summary {
        gap: 10px;
        margin-bottom: 16px;
    }

    .report-stat {
        padding: 13px;
    }

    .report-stat-icon {
        width: 32px;
        height: 32px;
        font-size: 16px;
    }

    .report-stat-value {
        font-size: 18px;
    }

    .report-table-heading {
        padding: 15px;
    }

    .report-table th,
    .report-table td {
        padding: 11px 12px;
    }
}
</style>

<div class="report-page">

    {{-- Header --}}
    <div class="report-heading">
        <div>
            <div class="report-eyebrow">Milnkys Workspace</div>
            <h1 class="report-title">Laporan Gudang</h1>
            <p class="report-description">
                Rekap biaya gudang, pesanan, resi, dan batch pengiriman.
            </p>
        </div>

        <div class="report-period-label">
            <span>📅</span>
            <span>
                {{ \Carbon\Carbon::parse($tanggalAwal)->format('d M Y') }}
                – {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Filter periode --}}
    <div class="report-card report-filter">
        <div class="report-filter-intro">
            <h2 class="report-section-heading">Filter Periode Laporan</h2>
            <p class="report-section-description">
                Pilih rentang tanggal untuk melihat rekap aktivitas gudang.
            </p>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}">
            <div class="report-filter-grid">
                <div class="report-field">
                    <label for="tanggal_awal">Tanggal Awal</label>
                    <input
                        type="date"
                        id="tanggal_awal"
                        name="tanggal_awal"
                        value="{{ $tanggalAwal }}"
                        max="{{ $tanggalAkhir }}"
                        required
                    >
                </div>

                <div class="report-field">
                    <label for="tanggal_akhir">Tanggal Akhir</label>
                    <input
                        type="date"
                        id="tanggal_akhir"
                        name="tanggal_akhir"
                        value="{{ $tanggalAkhir }}"
                        min="{{ $tanggalAwal }}"
                        required
                    >
                </div>
            </div>

            <div class="report-actions">
                <button type="submit" class="report-button report-button-primary">
                    <span>⌕</span> Tampilkan Laporan
                </button>

                <a
                    href="{{ route('laporan.pdf', request()->only('tanggal_awal', 'tanggal_akhir')) }}"
                    class="report-button report-button-pdf"
                >
                    <span>📄</span> Unduh PDF
                </a>

                <a
                    href="{{ route('laporan.excel', request()->only('tanggal_awal', 'tanggal_akhir')) }}"
                    class="report-button report-button-excel"
                >
                    <span>📊</span> Unduh Excel
                </a>
            </div>
        </form>
    </div>

    {{-- Kartu ringkasan --}}
    <div class="report-summary">

        <div class="report-card report-stat">
            <div class="report-stat-top">
                <div class="report-stat-label">Total Fee Gudang</div>
                <div class="report-stat-icon">💴</div>
            </div>
            <div class="report-stat-value">
                ¥{{ number_format($totalFeeJpy, 2) }}
            </div>
            <div class="report-stat-note">Total biaya dalam JPY</div>
        </div>

        <div class="report-card report-stat">
            <div class="report-stat-top">
                <div class="report-stat-label">Estimasi Rupiah</div>
                <div class="report-stat-icon">💰</div>
            </div>
            <div class="report-stat-value">
                @if ($totalRupiah !== null)
                    Rp{{ number_format($totalRupiah, 0, ',', '.') }}
                @else
                    <span style="font-size:15px">Belum ada kurs</span>
                @endif
            </div>
            <div class="report-stat-note">
                @if ($kurs !== null)
                    Kurs ¥1 = Rp{{ number_format($kurs, 2, ',', '.') }}
                @else
                    Atur kurs aktif terlebih dahulu
                @endif
            </div>
        </div>

        <div class="report-card report-stat">
            <div class="report-stat-top">
                <div class="report-stat-label">Total Pesanan</div>
                <div class="report-stat-icon">🛍️</div>
            </div>
            <div class="report-stat-value">
                {{ number_format($totalPesanan) }}
            </div>
            <div class="report-stat-note">Pesanan pada periode terpilih</div>
        </div>

        <div class="report-card report-stat">
            <div class="report-stat-top">
                <div class="report-stat-label">Total Resi</div>
                <div class="report-stat-icon">📦</div>
            </div>
            <div class="report-stat-value">
                {{ number_format($totalResi) }}
            </div>
            <div class="report-stat-note">
                {{ number_format($totalBatch) }} batch pengiriman
            </div>
        </div>

    </div>

    {{-- Detail pesanan --}}
    <div class="report-card report-table-card">
        <div class="report-table-heading">
            <div class="report-table-icon">🛍️</div>
            <div>
                <h2 class="report-table-title">Detail Pesanan</h2>
                <p class="report-table-subtitle">
                    {{ number_format($totalPesanan) }} pesanan dalam periode laporan
                </p>
            </div>
        </div>

        <div class="report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor Pesanan</th>
                        <th>Pelanggan</th>
                        <th class="text-right">Fee (JPY)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $item)
                        <tr>
                            <td class="report-date">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="report-primary-cell">
                                {{ $item->order_number ?? '-' }}
                            </td>
                            <td>{{ $item->customer_name ?? '-' }}</td>
                            <td class="text-right report-primary-cell">
                                ¥{{ number_format((float) $item->warehouse_fee_jpy, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="report-empty">
                                Belum ada pesanan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="report-footer">
            Total fee pesanan:
            <strong>¥{{ number_format($totalFeeJpy, 2) }}</strong>
        </div>
    </div>

    {{-- Detail resi --}}
    <div class="report-card report-table-card">
        <div class="report-table-heading">
            <div class="report-table-icon">📦</div>
            <div>
                <h2 class="report-table-title">Detail Resi / Barang Tiba</h2>
                <p class="report-table-subtitle">
                    {{ number_format($totalResi) }} resi pada periode laporan
                </p>
            </div>
        </div>

        <div class="report-table-wrap">
            <table class="report-table">
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
                            <td class="report-date">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="report-primary-cell">
                                {{ $item->tracking_number ?? '-' }}
                            </td>
                            <td class="report-date">
                                {{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="report-empty">
                                Belum ada resi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detail batch pengiriman --}}
    <div class="report-card report-table-card">
        <div class="report-table-heading">
            <div class="report-table-icon">🚚</div>
            <div>
                <h2 class="report-table-title">Detail Batch Pengiriman</h2>
                <p class="report-table-subtitle">
                    {{ number_format($totalBatch) }} batch pada periode laporan
                </p>
            </div>
        </div>

        <div class="report-table-wrap">
            <table class="report-table">
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
                            <td class="report-date">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="report-primary-cell">
                                {{ $item->name ?? '-' }}
                            </td>
                            <td>
                                @if ($item->is_closed)
                                    <span class="report-status report-status-closed">
                                        ✓ Ditutup
                                    </span>
                                @else
                                    <span class="report-status report-status-open">
                                        Berjalan
                                    </span>
                                @endif
                            </td>
                            <td class="report-date">
                                {{ $item->closed_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="report-empty">
                                Belum ada batch pengiriman pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection