<?php

namespace App\Http\Controllers;

use App\Models\ShipmentBatch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShipmentBatchController extends Controller
{
    public function index()
    {
        $batches = ShipmentBatch::withCount('arrivedItems')
            ->with(['arrivedItems.purchaseOrder'])
            ->latest()
            ->paginate(10);

        return view('shipment-batches.index', compact('batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shipment_batches', 'name'),
            ],
            'period_start' => [
                'required',
                'date',
            ],
            'period_end' => [
                'required',
                'date',
                'after_or_equal:period_start',
            ],
        ], [
            'name.required' => 'Nama box pengiriman wajib diisi.',
            'name.unique' => 'Nama box pengiriman sudah digunakan.',
            'period_start.required' => 'Periode mulai wajib diisi.',
            'period_end.required' => 'Periode selesai wajib diisi.',
            'period_end.after_or_equal' =>
                'Periode selesai tidak boleh sebelum periode mulai.',
        ]);

        ShipmentBatch::create([
            'name' => $validated['name'],
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'is_closed' => false,
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('shipment-batches.index')
            ->with('success', 'Box pengiriman berhasil dibuat.');
    }

    public function close(ShipmentBatch $shipmentBatch)
    {
        if ($shipmentBatch->is_closed) {
            return back()->with('error', 'Batch ini sudah ditutup.');
        }

        $shipmentBatch->update([
            'is_closed' => true,
            'closed_at' => now(),
        ]);

        return redirect()
            ->route('shipment-batches.index')
            ->with('success', 'Batch berhasil ditutup.');
    }

    public function show(ShipmentBatch $shipmentBatch)
    {
        $shipmentBatch->load([
            'arrivedItems.purchaseOrder',
        ]);

        return view('shipment-batches.show', compact('shipmentBatch'));
    }

    public function edit(ShipmentBatch $shipmentBatch)
{
    if ($shipmentBatch->is_closed) {
        return redirect()
            ->route('shipment-batches.index')
            ->with('error', 'Batch yang sudah ditutup tidak dapat diedit.');
    }

    return view('shipment-batches.edit', compact('shipmentBatch'));
}

public function update(Request $request, ShipmentBatch $shipmentBatch)
{
    if ($shipmentBatch->is_closed) {
        return redirect()
            ->route('shipment-batches.index')
            ->with('error', 'Batch yang sudah ditutup tidak dapat diedit.');
    }

    $validated = $request->validate([
        'name' => [
            'required',
            'string',
            'max:255',
            \Illuminate\Validation\Rule::unique('shipment_batches', 'name')
                ->ignore($shipmentBatch->id),
        ],
        'period_start' => ['required', 'date'],
        'period_end' => ['required', 'date', 'after_or_equal:period_start'],
    ]);

    $shipmentBatch->update($validated);

    return redirect()
        ->route('shipment-batches.index')
        ->with('success', 'Box pengiriman berhasil diperbarui.');
}

    public function destroy(ShipmentBatch $shipmentBatch)
{
    if ($shipmentBatch->arrivedItems()->exists()) {
        return redirect()
            ->route('shipment-batches.show', $shipmentBatch)
            ->with('error', 'Batch tidak dapat dihapus karena sudah memiliki barang/resi.');
    }

    $shipmentBatch->delete();

    return redirect()
        ->route('shipment-batches.index')
        ->with('success', 'Batch berhasil dihapus.');
}
public function reopen(ShipmentBatch $shipmentBatch)
{
    if (!$shipmentBatch->is_closed) {
        return back()->with('error', 'Batch ini masih terbuka.');
    }

    $shipmentBatch->update([
        'is_closed' => false,
        'closed_at' => null,
    ]);

    return redirect()
        ->route('shipment-batches.show', $shipmentBatch)
        ->with('success', 'Batch berhasil dibuka kembali.');
}

public function recap()
{
    $shipmentBatches = \App\Models\ShipmentBatch::with([
        'arrivedItems.purchaseOrder',
    ])
        ->withCount('arrivedItems')
        ->latest('created_at')
        ->get()
        ->map(function ($batch) {
            $batch->total_fee_jpy = $batch->arrivedItems
                ->pluck('purchaseOrder')
                ->filter()
                ->unique('id')
                ->sum(fn ($order) => (float) ($order->warehouse_fee_jpy ?? 0));

            return $batch;
        });

    return view('shipment-batches.recap', compact('shipmentBatches'));
}

}
