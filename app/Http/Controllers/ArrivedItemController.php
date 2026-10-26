<?php

namespace App\Http\Controllers;

use App\Models\ArrivedItem;
use App\Models\PurchaseOrder;
use App\Models\ShipmentBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArrivedItemController extends Controller
{
    public function index()
    {
        $arrivedItems = ArrivedItem::with([
            'purchaseOrder',
            'shipmentBatch',
        ])
            ->latest()
            ->paginate(15);

        return view('arrived-items.index', compact('arrivedItems'));
    }

    public function create()
    {
        $batches = ShipmentBatch::where('is_closed', false)
            ->orderBy('name')
            ->get();

        $purchaseOrders = PurchaseOrder::query()
            ->orderByDesc('created_at')
            ->get(['id', 'order_number', 'customer_name']);

        return view('arrived-items.create', compact(
            'batches',
            'purchaseOrders'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => [
                'required',
                'string',
                'max:255',
                'unique:arrived_items,tracking_number',
            ],
            'shipment_batch_id' => [
                'required',
                Rule::exists('shipment_batches', 'id')
                    ->where('is_closed', false),
            ],
            'purchase_order_id' => [
                'nullable',
                'exists:purchase_orders,id',
            ],
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
        ], [
            'tracking_number.required' => 'Nomor resi wajib diisi.',
            'tracking_number.unique' => 'Nomor resi ini sudah pernah diinput.',
            'shipment_batch_id.required' => 'Pilih box pengiriman.',
            'shipment_batch_id.exists' => 'Batch tidak valid atau sudah ditutup.',
            'purchase_order_id.exists' => 'Nomor order tidak ditemukan.',
            'photo.required' => 'Foto barang wajib diunggah.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Foto hanya boleh JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $photoPath = $request->file('photo')
            ->store('arrived-items', 'public');

        ArrivedItem::create([
            'tracking_number' => $validated['tracking_number'],
            'shipment_batch_id' => $validated['shipment_batch_id'],
            'purchase_order_id' => $validated['purchase_order_id'] ?? null,
            'photo_path' => $photoPath,
            'arrived_at' => now(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('arrived-items.index')
            ->with('success', 'Barang arrived berhasil disimpan.');
    }
    
public function show(ArrivedItem $arrivedItem)
{
    $arrivedItem->load(['purchaseOrder', 'shipmentBatch']);

    return view('arrived-items.show', compact('arrivedItem'));
}

public function edit(ArrivedItem $arrivedItem)
{
    // Barang dari batch yang sudah ditutup tidak boleh diedit.
    if ($arrivedItem->shipmentBatch?->is_closed) {
        return redirect()
            ->route('arrived-items.index')
            ->with('error', 'Barang dari batch yang sudah ditutup tidak dapat diedit.');
    }

    $batches = ShipmentBatch::where('is_closed', false)
        ->orderBy('name')
        ->get();

    $purchaseOrders = PurchaseOrder::query()
        ->orderByDesc('created_at')
        ->get(['id', 'order_number', 'customer_name']);

    $arrivedItem->load(['purchaseOrder', 'shipmentBatch']);

    return view('arrived-items.edit', compact(
        'arrivedItem',
        'batches',
        'purchaseOrders'
    ));
}

public function update(Request $request, ArrivedItem $arrivedItem)
{
    // Lindungi data yang sudah masuk batch tertutup.
    if ($arrivedItem->shipmentBatch?->is_closed) {
        return redirect()
            ->route('arrived-items.index')
            ->with('error', 'Barang dari batch yang sudah ditutup tidak dapat diedit.');
    }

    $validated = $request->validate([
        'tracking_number' => [
            'required',
            'string',
            'max:255',
            Rule::unique('arrived_items', 'tracking_number')
                ->ignore($arrivedItem->id),
        ],
        'shipment_batch_id' => [
            'required',
            Rule::exists('shipment_batches', 'id')
                ->where('is_closed', false),
        ],
        'purchase_order_id' => [
            'nullable',
            'exists:purchase_orders,id',
        ],
        'photo' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png',
            'max:5120',
        ],
    ], [
        'tracking_number.required' => 'Nomor resi wajib diisi.',
        'tracking_number.unique' => 'Nomor resi ini sudah digunakan.',
        'shipment_batch_id.required' => 'Pilih box pengiriman.',
        'shipment_batch_id.exists' => 'Batch tidak valid atau sudah ditutup.',
        'purchase_order_id.exists' => 'Nomor order tidak ditemukan.',
        'photo.image' => 'File harus berupa gambar.',
        'photo.mimes' => 'Foto hanya boleh JPG, JPEG, atau PNG.',
        'photo.max' => 'Ukuran foto maksimal 5 MB.',
    ]);

    $oldPhotoPath = $arrivedItem->photo_path;
    $newPhotoPath = null;

    if ($request->hasFile('photo')) {
        $newPhotoPath = $request->file('photo')
            ->store('arrived-items', 'public');

        $validated['photo_path'] = $newPhotoPath;
    }

    try {
        $arrivedItem->update([
            'tracking_number' => $validated['tracking_number'],
            'shipment_batch_id' => $validated['shipment_batch_id'],
            'purchase_order_id' => $validated['purchase_order_id'] ?? null,
            ...($newPhotoPath ? ['photo_path' => $newPhotoPath] : []),
        ]);
    } catch (\Throwable $e) {
        if ($newPhotoPath) {
            Storage::disk('public')->delete($newPhotoPath);
        }

        throw $e;
    }

    if ($newPhotoPath && $oldPhotoPath) {
        Storage::disk('public')->delete($oldPhotoPath);
    }

    return redirect()
        ->route('arrived-items.index')
        ->with('success', 'Data arrived berhasil diperbarui.');
}

public function destroy(ArrivedItem $arrivedItem)
{
    // Barang dari batch tertutup tidak boleh dihapus.
    if ($arrivedItem->shipmentBatch?->is_closed) {
        return redirect()
            ->route('arrived-items.index')
            ->with('error', 'Barang dari batch yang sudah ditutup tidak dapat dihapus.');
    }

    $photoPath = $arrivedItem->photo_path;

    $arrivedItem->delete();

    if ($photoPath) {
        Storage::disk('public')->delete($photoPath);
    }

    return redirect()
        ->route('arrived-items.index')
        ->with('success', 'Data arrived berhasil dihapus.');
}

}
