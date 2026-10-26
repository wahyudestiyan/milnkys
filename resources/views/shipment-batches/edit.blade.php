@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('shipment-batches.index') }}" class="back-link">
        ← Kembali ke Pengiriman Indonesia
    </a>

    <div class="page-header">
        <h1>Edit Box Pengiriman</h1>
        <p>Ubah nama dan periode box pengiriman.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="panel">
        <h2>Informasi Box</h2>

        <form
            action="{{ route('shipment-batches.update', $shipmentBatch) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <label for="name">Nama Box / Batch</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $shipmentBatch->name) }}"
                maxlength="255"
                required
            >

            <div class="period-fields">
                <div>
                    <label for="period_start">Periode Mulai</label>
                    <input
                        type="date"
                        id="period_start"
                        name="period_start"
                        value="{{ old('period_start', $shipmentBatch->period_start?->format('Y-m-d')) }}"
                        required
                        onchange="document.getElementById('period_end').min = this.value"
                    >
                </div>

                <div>
                    <label for="period_end">Periode Selesai</label>
                    <input
                        type="date"
                        id="period_end"
                        name="period_end"
                        value="{{ old('period_end', $shipmentBatch->period_end?->format('Y-m-d')) }}"
                        min="{{ old('period_start', $shipmentBatch->period_start?->format('Y-m-d')) }}"
                        required
                    >
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('shipment-batches.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
        color: #253126;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #506744;
        text-decoration: none;
        font-weight: 600;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0 0 6px;
        font-size: 26px;
    }

    .page-header p {
        margin: 0;
        color: #748075;
    }

    .panel {
        background: #fff;
        border: 1px solid #e4e9e2;
        border-radius: 14px;
        padding: 22px;
    }

    .panel h2 {
        margin: 0 0 18px;
        font-size: 18px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="date"] {
        width: 100%;
        max-width: 500px;
        padding: 11px 12px;
        border: 1px solid #d7ded5;
        border-radius: 8px;
        margin-bottom: 14px;
        box-sizing: border-box;
    }

    .period-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        max-width: 700px;
    }

    .actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .btn {
        display: inline-block;
        padding: 10px 14px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary {
        background: #9CB080;
        color: #fff;
    }

    .btn-secondary {
        background: #edf1e9;
        color: #40513c;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .alert-danger {
        background: #fff0ee;
        color: #9a2921;
    }

    @media (max-width: 600px) {
        .container {
            padding: 14px;
        }

        .panel {
            padding: 15px;
        }

        .period-fields {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
@endsection
