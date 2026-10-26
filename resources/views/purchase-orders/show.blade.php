@extends('layouts.app')

@section('title', 'Detail Purchase')
@section('page-title', 'Detail Purchase')
@section('page-subtitle', 'Informasi lengkap pesanan customer.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Detail Pesanan</h2>
        <p class="page-subtitle">
            Nomor order: {{ $purchase->order_number }}
        </p>
    </div>

    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="{{ route('purchase-orders.index') }}"
           class="btn btn-secondary">
            ← Kembali
        </a>

        <a href="{{ route('purchase-orders.edit', $purchase) }}"
           class="btn btn-primary">
            Edit Purchase
        </a>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h2>Informasi Pesanan</h2>
        <p>Data purchase yang telah dicatat.</p>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label class="form-label">Nomor Order</label>
            <div class="form-control">
                {{ $purchase->order_number }}
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Nama Customer</label>
            <div class="form-control">
                {{ $purchase->customer_name }}
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Purchase</label>
            <div class="form-control">
                {{ $purchase->purchaseType?->name ?? '-' }}
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Pembayaran</label>
            <div class="form-control">
                {{ $purchase->paymentType?->name ?? '-' }}
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Biaya Warehouse</label>
            <div class="form-control">
                ¥{{ number_format((float) $purchase->warehouse_fee_jpy, 2, '.', ',') }}
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Deadline Pembayaran</label>
            <div class="form-control">
                @if ($purchase->payment_deadline)
                    {{ $purchase->payment_deadline->format('d/m/Y H:i') }}
                @else
                    Tidak ditentukan
                @endif
            </div>
        </div>

        <div class="form-group full">
            <label class="form-label">Link Website</label>
            <div class="form-control" style="overflow-wrap:anywhere;">
                @if ($purchase->website_url)
                    <a href="{{ $purchase->website_url }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        {{ $purchase->website_url }}
                    </a>
                @else
                    Tidak ada link website
                @endif
            </div>
        </div>
    </div>
</div>

<div class="panel" style="margin-top:20px;">
    <div class="panel-header">
        <h2>Foto Bukti Purchase</h2>
        <p>Bukti pembelian yang tersimpan.</p>
    </div>

    <div style="padding:20px;">
        @if ($purchase->purchase_proof_path)
            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($purchase->purchase_proof_path) }}"
               target="_blank"
               rel="noopener noreferrer">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($purchase->purchase_proof_path) }}"
                    alt="Foto bukti purchase"
                    style="display:block; max-width:100%; max-height:500px; object-fit:contain; border-radius:10px;"
                >
            </a>

            <p class="form-help" style="margin-top:10px;">
                Klik foto untuk melihat ukuran penuh.
            </p>
        @else
            <div class="empty-state">
                <div class="empty-icon">📷</div>
                <strong>Belum ada foto bukti</strong>
                <p>Foto bukti purchase belum diunggah.</p>
            </div>
        @endif
    </div>
</div>

@endsection
