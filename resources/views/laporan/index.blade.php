@extends('layouts.app')

@section('content')
<style>
    .report-page {
        --report-green: #718968;
        --report-dark: #26382b;
        --report-muted: #849083;
        --report-bg: #f5f7f1;
        color: var(--report-dark);
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 28px;
        box-sizing: border-box;
    }

    .report-page * {
        box-sizing: border-box;
    }

    .report-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 26px;
    }

    .report-eyebrow {
        margin-bottom: 8px;
        color: var(--report-green);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .report-title {
        margin: 0;
        font-size: clamp(25px, 3vw, 32px);
        font-weight: 800;
        line-height: 1.25;
        letter-spacing: -0.8px;
    }

    .report-description {
        margin-top: 9px;
        color: var(--report-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .report-period-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        border: 1px solid #e5eade;
        border-radius: 12px;
        background: white;
        color: #61705d;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .report-card {
        min-width: 0;
        border: 1px solid #e9ede4;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(38, 56, 43, 0.035);
    }

    .report-filter {
        padding: 23px;
        margin-bottom: 22px;
    }

    .report-section-heading {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .report-section-description {
        margin-top: 6px;
        color: var(--report-muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .report-filter-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 16px;
        margin-top: 20px;
    }

    .report-field label {
        display: block;
        margin-bottom: 8px;
        color: #53614f;
        font-size: 12px;
        font-weight: 700;
    }

    .report-field input {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 45px;
        padding: 10px 12px;
        border: 1px solid #dfe5d9;
        border-radius: 11px;
        outline: none;
        background: #fbfcf9;
        color: var(--report-dark);
        font-family: inherit;
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    .report-field input:focus {
        border-color: var(--report-green);
        box-shadow: 0 0 0 3px rgba(113, 137, 104, .12);
    }

    .report-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .report-button {
        display: inline-flex;
        min-height: 43px;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid transparent;
        border-radius: 11px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        transition: transform .15s, opacity .15s, box-shadow .15s;
    }

    .report-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(38, 56, 43, .10);
    }

    .report-button-primary {
        background: var(--report-dark);
        color: #fff;
    }

    .report-button-pdf {
        border-color: #f2d8d4;
        background: #fff5f3;
        color: #b64e40;
    }

    .report-button-excel {
        border-color: #d6e9d8;
        background: #f1f8f0;
        color: #397447;
    }

    .report-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .report-stat {
        position: relative;
        overflow: hidden;
        padding: 21px;
    }

    .report-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .report-stat-label {
        color: var(--report-muted);
        font-size: 12px;
        font-weight: 650;
        line-height: 1.5;
    }

    .report-stat-icon {
        display: flex;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #edf3e9;
        font-size: 20px;
    }

    .report-stat-value {
        margin-top: 17px;
        overflow-wrap: anywhere;
        font-size: clamp(19px, 2vw, 26px);
        font-weight: 850;
        line-height: 1.35;
        letter-spacing: -.6px;
    }

    .report-stat-note {
        margin-top: 6px;
        color: #929c8d;
        font-size: 11px;
        line-height: 1.5;
    }

    .report-table-card {
        overflow: hidden;
        margin-bottom: 22px;
    }

    .report-table-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 21px 23px;
        border-bottom: 1px solid #edf0e9;
    }

    .report-table-icon {
        display: flex;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #edf3e9;
        font-size: 19px;
    }

    .report-table-title {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
    }

    .report-table-subtitle {
        margin-top: 5px;
        color: var(--report-muted);
        font-size: 11px;
    }

    .report-table-wrap {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .report-table {
        width: 100%;
        min-width: 570px;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
    }

    .report-table thead {
        background: #f8faf6;
    }

    .report-table th {
        padding: 14px 18px;
        color: #788473;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .report-table td {
        padding: 15px 18px;
        border-top: 1px solid #f0f2ed;
        color: #53614f;
        vertical-align: middle;
    }

    .report-table tbody tr {
        transition: background .15s;
    }

    .report-table tbody tr:hover {
        background: #fafbf8;
    }

    .report-table .text-right {
        text-align: right;
        white-space: nowrap;
    }

    .report-primary-cell {
        color: var(--report-dark) !important;
        font-weight: 750;
    }

    .report-date {
        white-space: nowrap;
        color: #778271;
        font-variant-numeric: tabular-nums;
    }

    .report-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .report-status-closed {
        background: #edf7ed;
        color: #3d7b49;
    }

    .report-status-open {
        background: #fff5df;
        color: #9a7024;
    }

    .report-empty {
        padding: 32px 16px !important;
        color: #939c8e !important;
        text-align: center;
    }

    .report-footer {
        padding: 15px 20px;
        border-top: 1px solid #edf0e9;
        color: #899383;
        font-size: 11px;
    }

    @media (min-width: 1024px) {
        .report-filter-grid {
            grid-template-columns: 230px 230px;
        }

        .report-filter {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
            gap: 22px;
        }

        .report-filter-intro {
            grid-column: 1 / -1;
        }

        .report-filter-grid {
            margin-top: 0;
        }

        .report-actions {
            margin-top: 0;
        }
    }

    @media (max-width: 1023px) {
        .report-page {
            padding: 22px;
        }

        .report-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .report-page {
            padding: 16px 12px 28px;
        }

        .report-heading {
            display: block;
            margin-bottom: 20px;
        }

        .report-period-label {
            margin-top: 13px;
            white-space: normal;
        }

        .report-filter {
            padding: 17px;
            border-radius: 17px;
        }

        .report-filter-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 13px;
        }

        .report-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .report-button {
            padding: 11px 9px;
            font-size: 11px;
        }

        .report-button-primary {
            grid-column: 1 / -1;
        }

        .report-summary {
            gap: 10px;
            margin-bottom: 18px;
        }

        .report-stat {
            padding: 15px;
            border-radius: 16px;
        }

        .report-stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            font-size: 16px;
        }

        .report-stat-value {
            margin-top: 13px;
            font-size: 19px;
        }

        .report-stat-label {
            font-size: 11px;
        }

        .report-table-heading {
            padding: 16px;
        }

        .report-table-icon {
            width: 36px;
            height: 36px;
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