@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 p-4 md:p-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Laporan Gudang
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Rekap fee, pesanan, resi, dan batch pengiriman.
        </p>
    </div>

    <form method="GET" action="{{ route('laporan.index') }}"
          class="flex flex-wrap items-end gap-4 rounded-xl bg-white p-4 shadow-sm">

        <div>
            <label for="tanggal_awal"
                   class="mb-1 block text-sm font-medium">
                Tanggal Awal
            </label>
            <input type="date" id="tanggal_awal" name="tanggal_awal"
                   value="{{ $tanggalAwal }}" required
                   class="rounded-lg border border-gray-300 p-2">
        </div>

        <div>
            <label for="tanggal_akhir"
                   class="mb-1 block text-sm font-medium">
                Tanggal Akhir
            </label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                   value="{{ $tanggalAkhir }}" required
                   class="rounded-lg border border-gray-300 p-2">
        </div>

        <button type="submit"
                class="rounded-lg bg-gray-800 px-5 py-2.5 text-white">
            Tampilkan
        </button>

        <a href="{{ route('laporan.pdf', request()->only('tanggal_awal', 'tanggal_akhir')) }}"
           class="rounded-lg bg-red-600 px-5 py-2.5 text-white">
            Unduh PDF
        </a>

        <a href="{{ route('laporan.excel', request()->only('tanggal_awal', 'tanggal_akhir')) }}"
           class="rounded-lg bg-green-700 px-5 py-2.5 text-white">
            Unduh Excel
        </a>
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Fee Gudang</p>
            <p class="mt-2 text-2xl font-bold">
                ¥{{ number_format($totalFeeJpy, 2) }}
            </p>
            <p class="mt-1 text-xs text-gray-400">JPY</p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Estimasi Rupiah</p>
            <p class="mt-2 text-2xl font-bold">
                @if ($totalRupiah !== null)
                    Rp{{ number_format($totalRupiah, 0, ',', '.') }}
                @else
                    Belum ada kurs
                @endif
            </p>
            <p class="mt-1 text-xs text-gray-400">
                @if ($kurs !== null)
                    Kurs: ¥1 = Rp{{ number_format($kurs, 2, ',', '.') }}
                @else
                    Atur kurs aktif terlebih dahulu
                @endif
            </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="mt-2 text-2xl font-bold">
                {{ number_format($totalPesanan) }}
            </p>
        </div>

        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Resi</p>
            <p class="mt-2 text-2xl font-bold">
                {{ number_format($totalResi) }}
            </p>
            <p class="mt-1 text-xs text-gray-400">
                {{ $totalBatch }} batch pengiriman
            </p>
        </div>

    </div>

    <div class="rounded-xl bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-lg font-bold">Detail Pesanan</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Nomor Pesanan</th>
                        <th class="p-3 text-left">Pelanggan</th>
                        <th class="p-3 text-right">Fee (JPY)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="p-3">
                                {{ $item->order_number ?? '-' }}
                            </td>
                            <td class="p-3">
                                {{ $item->customer_name ?? '-' }}
                            </td>
                            <td class="p-3 text-right">
                                ¥{{ number_format((float) $item->warehouse_fee_jpy, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Tidak ada pesanan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-lg font-bold">Detail Resi / Barang Tiba</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Tanggal Input</th>
                        <th class="p-3 text-left">Nomor Resi</th>
                        <th class="p-3 text-left">Tanggal Barang Tiba</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resi as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="p-3">{{ $item->tracking_number ?? '-' }}</td>
                            <td class="p-3">
                                {{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">
                                Tidak ada resi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-lg font-bold">Detail Batch Pengiriman</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Tanggal Dibuat</th>
                        <th class="p-3 text-left">Nama Batch</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Tanggal Ditutup</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($batch as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                {{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                            <td class="p-3">{{ $item->name ?? '-' }}</td>
                            <td class="p-3">
                                {{ $item->is_closed ? 'Ditutup' : 'Berjalan' }}
                            </td>
                            <td class="p-3">
                                {{ $item->closed_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Tidak ada batch pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
