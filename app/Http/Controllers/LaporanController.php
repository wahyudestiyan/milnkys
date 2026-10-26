<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExcelExport;
use App\Models\ArrivedItem;
use App\Models\ExchangeRate;
use App\Models\PurchaseOrder;
use App\Models\ShipmentBatch;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function dataLaporan(Request $request): array
    {
        $validated = $request->validate([
            'tanggal_awal' => ['nullable', 'date'],
            'tanggal_akhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_awal',
            ],
        ]);

        $tanggalAwal = $validated['tanggal_awal']
            ?? now()->startOfMonth()->toDateString();

        $tanggalAkhir = $validated['tanggal_akhir']
            ?? now()->toDateString();

        $awal = Carbon::parse($tanggalAwal)->startOfDay();
        $akhir = Carbon::parse($tanggalAkhir)->endOfDay();

        $pesanan = PurchaseOrder::query()
            ->whereBetween('created_at', [$awal, $akhir])
            ->orderByDesc('created_at')
            ->get();

        $resi = ArrivedItem::query()
            ->whereBetween('created_at', [$awal, $akhir])
            ->orderByDesc('created_at')
            ->get();

        $batch = ShipmentBatch::query()
            ->whereBetween('created_at', [$awal, $akhir])
            ->orderByDesc('created_at')
            ->get();

        $totalFeeJpy = (float) $pesanan->sum(
            fn ($item) => (float) ($item->warehouse_fee_jpy ?? 0)
        );

        $kurs = ExchangeRate::current();

        $nilaiKurs = $kurs ? (float) $kurs->rate : null;

        $totalRupiah = $nilaiKurs !== null
            ? $totalFeeJpy * $nilaiKurs
            : null;

        return [
            'tanggalAwal' => $awal->toDateString(),
            'tanggalAkhir' => $akhir->toDateString(),
            'pesanan' => $pesanan,
            'resi' => $resi,
            'batch' => $batch,
            'totalPesanan' => $pesanan->count(),
            'totalResi' => $resi->count(),
            'totalBatch' => $batch->count(),
            'totalFeeJpy' => $totalFeeJpy,
            'kurs' => $nilaiKurs,
            'totalRupiah' => $totalRupiah,
        ];
    }

    public function index(Request $request)
    {
        $laporan = $this->dataLaporan($request);

        return view('laporan.index', $laporan);
    }

    public function pdf(Request $request)
    {
        $laporan = $this->dataLaporan($request);

        $pdf = Pdf::loadView('laporan.pdf', $laporan)
            ->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-gudang-'
            . $laporan['tanggalAwal'] . '-'
            . $laporan['tanggalAkhir'] . '.pdf'
        );
    }

    public function excel(Request $request)
    {
        $laporan = $this->dataLaporan($request);

        return (new LaporanExcelExport($laporan))->download(
            'laporan-gudang-'
            . $laporan['tanggalAwal'] . '-'
            . $laporan['tanggalAkhir'] . '.xlsx'
        );
    }
}
