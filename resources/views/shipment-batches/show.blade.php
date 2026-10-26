@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('shipment-batches.index') }}" class="back-link">
        ← Kembali ke Pengiriman Indonesia
    </a>

    <div class="page-header">
    <div>
        <h1>{{ $shipmentBatch->name }}</h1>
        <p>Detail barang yang masuk dalam box pengiriman ini.</p>
    </div>

</div>

<div class="purchase-actions">
    <a href="{{ route('shipment-batches.index') }}"
       class="btn-action btn-view">
        Lihat
    </a>

    @if (!$shipmentBatch->is_closed)
        <a href="{{ route('shipment-batches.edit', $shipmentBatch) }}"
           class="btn-action btn-edit">
            Edit
        </a>
    @endif

    @if ($shipmentBatch->arrivedItems->isEmpty() && !$shipmentBatch->is_closed)
        <form action="{{ route('shipment-batches.destroy', $shipmentBatch) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus batch ini?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn-action btn-delete">
                Hapus
            </button>
        </form>
    @endif

    @if ($shipmentBatch->is_closed)
        <form action="{{ route('shipment-batches.reopen', $shipmentBatch) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin membuka kembali batch ini?')">
            @csrf
            @method('PATCH')

            <button type="submit" class="btn-action btn-open">
                Buka Batch
            </button>
        </form>
    @else
        <form action="{{ route('shipment-batches.close', $shipmentBatch) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menutup batch ini?')">
            @csrf
            @method('PATCH')

            <button type="submit" class="btn-action btn-close">
                Tutup Batch
            </button>
        </form>
    @endif

    @if ($shipmentBatch->is_closed)
        <span class="status closed">Batch Ditutup</span>
    @else
        <span class="status open">Batch Terbuka</span>
    @endif
</div>


</div>


<div class="summary">
    <div class="summary-card">
        <span>Total Resi</span>
        <strong>{{ $shipmentBatch->arrivedItems->count() }}</strong>
    </div>

    <div class="summary-card">
        <span>Periode Mulai</span>
        <strong>
            {{ $shipmentBatch->period_start?->format('d/m/Y') ?? '-' }}
        </strong>
    </div>

    <div class="summary-card">
        <span>Periode Selesai</span>
        <strong>
            {{ $shipmentBatch->period_end?->format('d/m/Y') ?? '-' }}
        </strong>
    </div>

    <div class="summary-card">
        <span>Tanggal Dibuat</span>
        <strong>
            {{ $shipmentBatch->created_at?->format('d/m/Y H:i') ?? '-' }}
        </strong>
    </div>

    <div class="summary-card">
        <span>Tanggal Ditutup Aktual</span>
        <strong>
            {{ $shipmentBatch->closed_at?->format('d/m/Y H:i') ?? 'Belum ditutup' }}
        </strong>
    </div>
</div>


    <div class="panel">
        <h2>Daftar Barang Tiba</h2>

        @if ($shipmentBatch->arrivedItems->isEmpty())
            <div class="empty-state">
                Belum ada barang yang dimasukkan ke batch ini.
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Foto Barang</th>
                            <th>Nomor Resi</th>
                            <th>Nomor Purchase</th>
                            <th>Customer</th>
                            <th>Tanggal Tiba</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipmentBatch->arrivedItems as $item)
                            <tr>
                                <td>
                                    @if ($item->photo_path)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->photo_path) }}" target="_blank" rel="noopener">
                                            <img
                                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->photo_path) }}"
                                                alt="Foto {{ $item->tracking_number }}"
                                                class="item-photo"
                                            >
                                        </a>
                                    @else
                                        <span class="no-photo">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td><strong>{{ $item->tracking_number }}</strong></td>
                                <td>{{ $item->purchaseOrder?->order_number ?? '-' }}</td>
                                <td>{{ $item->purchaseOrder?->customer_name ?? '-' }}</td>
                                <td>{{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
    .container { max-width: 1200px; margin: 0 auto; padding: 24px; color: #253126; }
    .back-link { display: inline-block; margin-bottom: 20px; color: #506744; text-decoration: none; font-weight: 600; }
    .page-header { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 24px; }
    .page-header h1 { margin: 0 0 6px; font-size: 26px; }
    .page-header p { margin: 0; color: #748075; }
    .summary { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 22px; }
    .summary-card { background: #fff; border: 1px solid #e4e9e2; border-radius: 12px; padding: 18px; }
    .summary-card span { display: block; color: #748075; font-size: 13px; margin-bottom: 8px; }
    .summary-card strong { font-size: 20px; overflow-wrap: anywhere; }
    .panel { background: #fff; border: 1px solid #e4e9e2; border-radius: 14px; padding: 22px; }
    .panel h2 { margin: 0 0 18px; font-size: 18px; }
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; min-width: 650px; border-collapse: collapse; }
    th, td { text-align: left; padding: 12px; border-bottom: 1px solid #edf0eb; vertical-align: middle; }
    th { background: #f7f9f5; color: #667263; font-size: 12px; text-transform: uppercase; }
    .item-photo { width: 64px; height: 64px; object-fit: cover; border-radius: 8px; }
    .no-photo { color: #888; font-size: 12px; }
    .status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}
    .status.open { background: #e6f4e5; color: #28632d; }
    .status.closed { background: #eee; color: #666; }
    .empty-state { padding: 28px 12px; text-align: center; color: #788174; background: #f8faf7; border-radius: 10px; }


@media (max-width: 650px) {
    .container {
        padding: 14px;
    }

    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .header-actions {
        width: 100%;
    }

    .summary {
        grid-template-columns: 1fr;
    }

    .panel {
        padding: 14px;
    }

    .btn,
    button {
        padding: 5px 8px;
        font-size: 11px;
    }

    .status {
        padding: 4px 7px;
        font-size: 10px;
    }
}
</style>
@endsection
