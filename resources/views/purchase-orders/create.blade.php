@extends('layouts.app')

@section('title', 'Input Purchase')
@section('page-title', 'Input Purchase')
@section('page-subtitle', 'Catat pesanan customer dan biaya warehouse Jepang.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Pesanan Baru</h2>
        <p class="page-subtitle">Lengkapi informasi pembelian di bawah ini.</p>
    </div>
    <span class="badge">🛍 Pembelian</span>
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

<form action="{{ route('purchase-orders.store') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <section class="panel">
        <div class="panel-header">
            <h2>Informasi Pesanan</h2>
            <p>Nama customer dan nomor order diisi manual oleh Admin Milnkys.</p>
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
                       value="{{ old('customer_name') }}"
                       placeholder="Masukkan nama customer"
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
                       value="{{ old('order_number') }}"
                       placeholder="Contoh: ORD-2026-001"
                       maxlength="255"
                       required>
                <div class="form-help">
                    Masukkan nomor order asli dari website atau penjual.
                </div>
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
                            @selected(old('purchase_type_id') == $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @if ($purchaseTypes->isEmpty())
                    <div class="form-help">
                        Belum ada jenis purchase aktif. Tambahkan melalui menu Pengaturan.
                    </div>
                @endif
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
                            @selected(old('payment_type_id') == $type->id)>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @if ($paymentTypes->isEmpty())
                    <div class="form-help">
                        Belum ada jenis pembayaran aktif. Tambahkan melalui menu Pengaturan.
                    </div>
                @endif
                @error('payment_type_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

           <div class="form-group full">
                <label class="form-label" for="website_url">Link Website</label>
                <input class="form-control"
                    id="website_url"
                    type="url"
                    name="website_url"
                    value="{{ old('website_url') }}"
                    placeholder="https://contoh-website.jp">

                <div class="form-help">
                    Opsional. Kosongkan jika tidak ada link website.
                </div>

                @error('website_url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </section>

    <section class="panel" style="margin-top:20px;">
        <div class="panel-header">
            <h2>Bukti dan Pembayaran</h2>
            <p>Unggah bukti pembelian dan catat tenggat pembayaran jika ada.</p>
        </div>

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label" for="purchase_proof">
                    Foto Bukti Purchase
                </label>
                <input class="form-control"
                       id="purchase_proof"
                       type="file"
                       name="purchase_proof"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                <div class="form-help">Format JPG atau PNG, maksimal 5 MB.</div>
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
                    value="{{ old('payment_deadline') }}">

                <div class="form-help">
                    Opsional. Kosongkan jika belum ada deadline pembayaran.
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
                       value="{{ old('warehouse_fee_jpy', '0.00') }}"
                       min="0"
                       max="9999999999999.99"
                       step="0.01"
                       placeholder="0.00"
                       required>
                <div class="form-help">Masukkan biaya dalam Yen Jepang (¥).</div>
                @error('warehouse_fee_jpy')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('purchase-orders.index') }}"
               class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                ✓ &nbsp; Simpan Purchase
            </button>
        </div>
    </section>
</form>

@endsection