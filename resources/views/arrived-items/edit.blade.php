@extends('layouts.app')

@section('title', 'Edit Arrived')
@section('page-title', 'Edit Barang Tiba')
@section('page-subtitle', 'Perbarui informasi barang arrived.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Edit Nomor Resi</h2>
        <p class="page-subtitle">
            Resi: {{ $arrivedItem->tracking_number }}
        </p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="panel">
    <form
        action="{{ route('arrived-items.update', $arrivedItem) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <label for="tracking_number">
            Nomor Resi
        </label>

        <input
            type="text"
            id="tracking_number"
            name="tracking_number"
            value="{{ old('tracking_number', $arrivedItem->tracking_number) }}"
            maxlength="255"
            required
        >

        <label for="purchase_order_id">
            Nomor Order / Customer
        </label>

        <select id="purchase_order_id" name="purchase_order_id">
            <option value="">-- Tanpa Purchase Order --</option>

            @foreach ($purchaseOrders as $order)
                <option
                    value="{{ $order->id }}"
                    @selected(
                        (string) old('purchase_order_id', $arrivedItem->purchase_order_id)
                        === (string) $order->id
                    )
                >
                    {{ $order->order_number }} - {{ $order->customer_name }}
                </option>
            @endforeach
        </select>

        <label for="shipment_batch_id">
            Box Pengiriman
        </label>

        <select
            id="shipment_batch_id"
            name="shipment_batch_id"
            required
        >
            @foreach ($batches as $batch)
                <option
                    value="{{ $batch->id }}"
                    @selected(
                        (string) old('shipment_batch_id', $arrivedItem->shipment_batch_id)
                        === (string) $batch->id
                    )
                >
                    {{ $batch->name }}
                </option>
            @endforeach
        </select>

        <label>Foto Saat Ini</label>

        @if ($arrivedItem->photo_path)
            <div class="current-photo">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($arrivedItem->photo_path) }}"
                    alt="Foto barang saat ini"
                >
            </div>
        @else
            <p>Belum ada foto.</p>
        @endif

        <label for="photo">
            Ganti Foto (Opsional)
        </label>

        <input
            type="file"
            id="photo"
            name="photo"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        >

        <small>
            Format JPG, JPEG, atau PNG. Maksimal 5 MB.
        </small>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

            <a
                href="{{ route('arrived-items.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>
        </div>
    </form>
</div>

<style>
    .panel label {
        display: block;
        margin: 16px 0 7px;
        font-weight: 600;
    }

    .panel input[type="text"],
    .panel input[type="file"],
    .panel select {
        display: block;
        width: 100%;
        max-width: 600px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 7px;
        box-sizing: border-box;
        background: var(--surface);
        color: var(--text);
    }

    .panel input:focus,
    .panel select:focus {
        border-color: var(--primary);
        outline: none;
    }

    .panel small {
        display: block;
        margin-top: 7px;
        color: var(--muted);
    }

    .current-photo {
        margin: 8px 0 16px;
    }

    .current-photo img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
    }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 24px;
    }
</style>

@endsection