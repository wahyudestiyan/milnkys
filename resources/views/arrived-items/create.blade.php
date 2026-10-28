@extends('layouts.app')

@section('title', 'Input Arrived')
@section('page-title', 'Input Arrived')
@section('page-subtitle', 'Catat barang yang sudah tiba di warehouse Jepang.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Input Barang Tiba</h2>
        <p class="page-subtitle">
            Masukkan nomor resi, foto barang, dan box pengiriman.
        </p>
    </div>

    <a href="{{ route('arrived-items.index') }}"
       class="btn btn-secondary">
        Lihat Daftar Arrived
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Periksa kembali data berikut:</strong>

        <ul style="margin: 8px 0 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('arrived-items.store') }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <section class="panel">
        <div class="panel-header">
            <h2>Informasi Barang</h2>
            <p>Isi data barang yang baru tiba di warehouse Jepang.</p>
        </div>

        <div class="form-grid">

            {{-- Nomor Resi --}}
            <div class="form-group full">
                <label class="form-label" for="tracking_number">
                    Nomor Resi <span class="required">*</span>
                </label>

                <input
                    class="form-control"
                    id="tracking_number"
                    type="text"
                    name="tracking_number"
                    value="{{ old('tracking_number') }}"
                    placeholder="Masukkan nomor resi"
                    maxlength="255"
                    required
                    autofocus
                >

                @error('tracking_number')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Box Pengiriman --}}
            <div class="form-group full">
                <label class="form-label" for="shipment_batch_id">
                    Box Pengiriman <span class="required">*</span>
                </label>

                <select
                    class="form-control"
                    id="shipment_batch_id"
                    name="shipment_batch_id"
                    required
                >
                    <option value="">Pilih box pengiriman</option>

                    @foreach ($batches as $batch)
                        <option
                            value="{{ $batch->id }}"
                            @selected(old('shipment_batch_id') == $batch->id)
                        >
                            {{ $batch->name }}
                        </option>
                    @endforeach
                </select>

                @if ($batches->isEmpty())
                    <div class="form-help">
                        Belum ada batch terbuka. Minta admin membuat
                        atau membuka batch pengiriman terlebih dahulu.
                    </div>
                @else
                    <div class="form-help">
                        Hanya batch yang masih terbuka yang ditampilkan.
                    </div>
                @endif

                @error('shipment_batch_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nomor Order Purchase --}}
            <div class="form-group full">
                <label class="form-label" for="purchase_order_id">
                    Nomor Order Purchase
                </label>

                <select
                    class="form-control"
                    id="purchase_order_id"
                    name="purchase_order_id"
                >
                    <option value="">Tidak memilih order</option>

                    @foreach ($purchaseOrders as $order)
                        <option
                            value="{{ $order->id }}"
                            @selected(old('purchase_order_id') == $order->id)
                        >
                            {{ $order->order_number }}
                            — {{ $order->customer_name }}
                        </option>
                    @endforeach
                </select>

                <div class="form-help">
                    Opsional. Pilih order yang sesuai jika sudah diketahui.
                </div>

                @error('purchase_order_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto Barang --}}
            <div class="form-group full">
                <label class="form-label" for="photo">
                    Foto Barang Arrived <span class="required">*</span>
                </label>

                <input
                    class="form-control"
                    id="photo"
                    type="file"
                    name="photo"
                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                    required
                >

                <div class="form-help">
                    Format JPG atau PNG, maksimal 5 MB.
                </div>

                <div
                    id="photo-preview-wrap"
                    style="display: none; margin-top: 12px;"
                >
                    <img
                        id="photo-preview"
                        src=""
                        alt="Preview foto barang"
                        style="max-width: 100%; max-height: 300px; object-fit: contain; border-radius: 10px;"
                    >
                </div>

                @error('photo')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('arrived-items.index') }}"
               class="btn btn-secondary">
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
                @disabled($batches->isEmpty())
            >
                ✓ &nbsp; Simpan Arrived
            </button>
        </div>
    </section>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('photo');
    const wrap = document.getElementById('photo-preview-wrap');
    const preview = document.getElementById('photo-preview');

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            preview.removeAttribute('src');
            wrap.style.display = 'none';
            return;
        }

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Foto harus berformat JPG atau PNG.');
            this.value = '';
            preview.removeAttribute('src');
            wrap.style.display = 'none';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran foto maksimal 5 MB.');
            this.value = '';
            preview.removeAttribute('src');
            wrap.style.display = 'none';
            return;
        }

        preview.src = URL.createObjectURL(file);
        wrap.style.display = 'block';
    });
});
</script>

@endsection