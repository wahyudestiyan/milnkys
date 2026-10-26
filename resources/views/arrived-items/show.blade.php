@extends('layouts.app')

@section('title', 'Detail Arrived')
@section('page-title', 'Detail Barang Tiba')
@section('page-subtitle', 'Informasi lengkap barang yang sudah tiba.')

@section('content')
<div class="section-heading">
    <div>
        <h2>{{ $arrivedItem->tracking_number }}</h2>
        <p class="page-subtitle">Detail barang arrived.</p>
    </div>

    <div class="actions">
        <a href="{{ route('arrived-items.index') }}" class="btn btn-secondary">
            Kembali
        </a>

        @if (!$arrivedItem->shipmentBatch?->is_closed)
            <a href="{{ route('arrived-items.edit', $arrivedItem) }}"
               class="btn btn-primary">
                Edit
            </a>
        @endif
    </div>
</div>

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="panel">
    <div class="panel-header">
        <h2>Informasi Barang</h2>
    </div>

    <div class="detail-grid">
        <div>
            <span>Nomor Resi</span>
            <strong>{{ $arrivedItem->tracking_number }}</strong>
        </div>

        <div>
            <span>Nomor Order</span>
            <strong>{{ $arrivedItem->purchaseOrder?->order_number ?? '-' }}</strong>
        </div>

        <div>
            <span>Customer</span>
            <strong>{{ $arrivedItem->purchaseOrder?->customer_name ?? '-' }}</strong>
        </div>

        <div>
            <span>Box Pengiriman</span>
            <strong>{{ $arrivedItem->shipmentBatch?->name ?? '-' }}</strong>
        </div>

        <div>
            <span>Status Batch</span>
            <strong>
                @if ($arrivedItem->shipmentBatch?->is_closed)
                    Ditutup
                @else
                    Terbuka
                @endif
            </strong>
        </div>

        <div>
            <span>Waktu Input</span>
            <strong>{{ $arrivedItem->arrived_at?->format('d/m/Y H:i') ?? '-' }}</strong>
        </div>
    </div>

    <div class="photo-section">
        <h3>Foto Barang</h3>

        @if ($arrivedItem->photo_path)
            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($arrivedItem->photo_path) }}"
               target="_blank" rel="noopener noreferrer">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($arrivedItem->photo_path) }}"
                    alt="Foto {{ $arrivedItem->tracking_number }}"
                    class="item-photo"
                >
            </a>
        @else
            <p>Foto tidak tersedia.</p>
        @endif
    </div>

    @if (!$arrivedItem->shipmentBatch?->is_closed)
        <form
            action="{{ route('arrived-items.destroy', $arrivedItem) }}"
            method="POST"
            onsubmit="return confirm('Yakin ingin menghapus data arrived ini?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit" class="action-btn btn-delete">
                Hapus Barang
            </button>
        </form>
    @endif
</div>

<style>
    .actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .detail-grid span {
        display: block;
        color: #748075;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .detail-grid strong {
        overflow-wrap: anywhere;
    }

    .photo-section {
        margin-bottom: 24px;
    }

    .photo-section h3 {
        font-size: 15px;
        margin-bottom: 12px;
    }

    .item-photo {
        width: 100%;
        max-width: 320px;
        max-height: 400px;
        object-fit: contain;
        border-radius: 10px;
        border: 1px solid #e4e9e2;
    }

    .action-btn {
        display: inline-block;
        padding: 5px 9px;
        border: 1px solid #f5d0cc;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        background: #fef0ef;
        color: #b42318;
        cursor: pointer;
    }

    @media (max-width: 600px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }
</style>
@endsection
