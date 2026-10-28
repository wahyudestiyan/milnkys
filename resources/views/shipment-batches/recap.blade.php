@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <div>
            <h1>Rekap Pengiriman Indonesia</h1>
            <p>Ringkasan resi, fee, dan periode setiap batch pengiriman.</p>
        </div>

        <a href="{{ route('shipment-batches.index') }}"
           class="btn-action btn-view">
            Daftar Batch
        </a>
    </div>

    @php
        $totalBatch = $shipmentBatches->count();
        $totalResi = $shipmentBatches->sum('arrived_items_count');
        $totalFee = $shipmentBatches->sum('total_fee_jpy');
    @endphp

    <div class="summary">
        <div class="summary-card">
            <span>Total Batch</span>
            <strong>{{ number_format($totalBatch, 0, ',', '.') }}</strong>
        </div>

        <div class="summary-card">
            <span>Total Resi</span>
            <strong>{{ number_format($totalResi, 0, ',', '.') }}</strong>
        </div>

        <div class="summary-card">
            <span>Total Fee Gudang</span>
            <strong>¥{{ number_format($totalFee, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="panel">
        <h2>Rekap per Batch</h2>

        @if ($shipmentBatches->isEmpty())
            <div class="empty-state">
                Belum ada data batch pengiriman.
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Batch</th>
                            <th>Total Resi</th>
                            <th>Total Fee (JPY)</th>
                            <th>Periode Mulai</th>
                            <th>Periode Akhir Rencana</th>
                            <th>Penutupan Aktual</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($shipmentBatches as $batch)
                            <tr>
                                <td>
                                    <strong>{{ $batch->name }}</strong>
                                </td>

                                <td>
                                    {{ number_format($batch->arrived_items_count, 0, ',', '.') }}
                                </td>

                                <td>
                                    ¥{{ number_format($batch->total_fee_jpy, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $batch->period_start?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    {{ $batch->period_end?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    @if ($batch->closed_at)
                                        {{ $batch->closed_at->format('d/m/Y H:i') }}
                                    @else
                                        <span class="not-closed">Belum ditutup</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($batch->is_closed)
                                        <span class="status closed">Ditutup</span>
                                    @else
                                        <span class="status open">Terbuka</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('shipment-batches.show', $batch) }}"
                                       class="btn-action btn-view">
                                        Detail Barang
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{ number_format($totalResi, 0, ',', '.') }}</th>
                            <th>¥{{ number_format($totalFee, 0, ',', '.') }}</th>
                            <th colspan="5"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>


<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
        color: var(--text);
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .page-header h1 {
        margin: 0 0 6px;
        font-size: 26px;
        color: var(--text);
    }

    .page-header p {
        margin: 0;
        color: var(--muted);
    }

    .summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .summary-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
    }

    .summary-card span {
        display: block;
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 8px;
    }

    .summary-card strong {
        font-size: 22px;
        overflow-wrap: anywhere;
        color: var(--text);
    }

    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
    }

    .panel h2 {
        margin: 0 0 18px;
        font-size: 18px;
        color: var(--text);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        white-space: nowrap;
        color: var(--text);
    }

    thead th {
        background: var(--primary-soft);
        color: var(--primary-dark);
        font-size: 11px;
        text-transform: uppercase;
    }

    tfoot th {
        background: var(--bg);
        color: var(--text);
        font-size: 12px;
    }

    .purchase-actions {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 9px;
        font-family: inherit;
        font-size: 11px;
        line-height: 1.3;
        font-weight: 600;
        border: 1px solid transparent;
        border-radius: 5px;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-view {
        background: var(--primary-soft);
        border-color: var(--border);
        color: var(--primary-dark);
    }

    .status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status.open {
        background: var(--success-soft);
        color: var(--success);
    }

    .status.closed {
        background: var(--bg);
        color: var(--muted);
    }

    .not-closed {
        color: var(--warning, var(--muted));
        font-size: 12px;
    }

    .empty-state {
        padding: 28px 12px;
        text-align: center;
        color: var(--muted);
        background: var(--bg);
        border-radius: 10px;
    }

    @media (max-width: 650px) {
        .container {
            padding: 14px;
        }

        .summary {
            grid-template-columns: 1fr;
        }

        .panel {
            padding: 14px;
        }
    }
</style>

@endsection
