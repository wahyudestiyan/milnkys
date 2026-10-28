@extends('layouts.app')

@section('title', 'Edit Purchase')
@section('page-title', 'Edit Purchase')
@section('page-subtitle', 'Perbarui informasi pesanan customer.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Edit Pesanan</h2>
        <p class="page-subtitle">
            Nomor order: {{ $purchase->order_number }}
        </p>
    </div>

    <a href="{{ route('purchase-orders.show', $purchase) }}"
       class="btn btn-secondary">
        ← Kembali ke Detail
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Periksa kembali data berikut:</strong>
        <ul style="margin:8px 0 0;padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('purchase-orders.update', $purchase) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <section class="panel">
        <div class="panel-header">
            <h2>Informasi Pesanan</h2>
            <p>Ubah data sesuai informasi purchase terbaru.</p>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="customer_name">
                    Nama Customer <span class="required">*</span>
                </label>
                <input class="form-control"
                       id="customer_name"
                       type="text"
                       name="customer_name"
                       value="{{ old('customer_name', $purchase->customer_name) }}"
                       maxlength="255"
                       required>
                @error('customer_name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="order_number">
                    Nomor Order <span class="required">*</span>
                </label>
                <input class="form-control"
                       id="order_number"
                       type="text"
                       name="order_number"
                       value="{{ old('order_number', $purchase->order_number) }}"
                       maxlength="255"
                       required>
                @error('order_number')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="purchase_type_id">
                    Jenis Purchase <span class="required">*</span>
                </label>
                <select class="form-control"
                        id="purchase_type_id"
                        name="purchase_type_id"
                        required>
                    <option value="">Pilih jenis purchase</option>
                    @foreach ($purchaseTypes as $type)
                        <option value="{{ $type->id }}"
                            @selected(old('purchase_type_id', $purchase->purchase_type_id) == $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('purchase_type_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="payment_type_id">
                    Jenis Pembayaran <span class="required">*</span>
                </label>
                <select class="form-control"
                        id="payment_type_id"
                        name="payment_type_id"
                        required>
                    <option value="">Pilih jenis pembayaran</option>
                    @foreach ($paymentTypes as $type)
                        <option value="{{ $type->id }}"
                            @selected(old('payment_type_id', $purchase->payment_type_id) == $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('payment_type_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full">
                <label class="form-label" for="website_url">
                    Link Website
                </label>
                <input class="form-control"
                       id="website_url"
                       type="url"
                       name="website_url"
                       value="{{ old('website_url', $purchase->website_url) }}"
                       placeholder="https://contoh-website.jp">
                <div class="form-help">
                    Opsional. Kosongkan jika tidak ada link website.
                </div>
                @error('website_url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group full">
                <label class="form-label" for="payment_url">
                    Link Payment
                </label>

                <input class="form-control"
                    id="payment_url"
                    type="url"
                    name="payment_url"
                    value="{{ old('payment_url', $purchase->payment_url) }}"
                    placeholder="https://contoh-payment.jp">

                <div class="form-help">
                    Link ini akan disertakan dalam email pengingat deadline pembayaran.
                </div>

                @error('payment_url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </section>

    <section class="panel" style="margin-top:20px;">
        <div class="panel-header">
            <h2>Bukti dan Pembayaran</h2>
            <p>Perbarui foto atau informasi pembayaran jika diperlukan.</p>
        </div>

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label">Foto Bukti Saat Ini</label>

                @if ($purchase->purchase_proof_path)
                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($purchase->purchase_proof_path) }}"
                       target="_blank"
                       rel="noopener noreferrer">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($purchase->purchase_proof_path) }}"
                            alt="Foto bukti purchase saat ini"
                            style="display:block; max-width:100%; max-height:300px; object-fit:contain; border-radius:10px;"
                        >
                    </a>
                @else
                    <p class="form-help">Belum ada foto bukti yang diunggah.</p>
                @endif
            </div>

            <div class="form-group full">
                <label class="form-label" for="purchase_proof">
                    Ganti Foto Bukti Purchase
                </label>
                <input class="form-control"
                       id="purchase_proof"
                       type="file"
                       name="purchase_proof"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <div class="form-help">
                    Opsional. JPG atau PNG, maksimal 5 MB.
                    Kosongkan jika foto lama ingin tetap digunakan.
                </div>
                @error('purchase_proof')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="payment_deadline">
                    Deadline Pembayaran
                </label>
                <input class="form-control"
                       id="payment_deadline"
                       type="datetime-local"
                       name="payment_deadline"
                       value="{{ old('payment_deadline', $purchase->payment_deadline ? $purchase->payment_deadline->format('Y-m-d\TH:i') : '') }}">
                <div class="form-help">
                    Opsional. Kosongkan jika tidak ada deadline.
                </div>
                @error('payment_deadline')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="warehouse_fee_jpy">
                    Biaya Warehouse (JPY) <span class="required">*</span>
                </label>
                <input class="form-control"
                       id="warehouse_fee_jpy"
                       type="number"
                       name="warehouse_fee_jpy"
                       value="{{ old('warehouse_fee_jpy', $purchase->warehouse_fee_jpy) }}"
                       min="0"
                       max="9999999999999.99"
                       step="0.01"
                       required>
                <div class="form-help">
                    Masukkan biaya dalam Yen Jepang (¥).
                </div>
                @error('warehouse_fee_jpy')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('purchase-orders.show', $purchase) }}"
               class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                ✓ &nbsp; Simpan Perubahan
            </button>
        </div>
    </section>
</form>

@endsection
