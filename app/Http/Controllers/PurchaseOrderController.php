<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseType;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with([
            'purchaseType',
            'paymentType',
        ])->latest()->paginate(10);

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $purchaseTypes = PurchaseType::where('is_active', true)
            ->orderBy('name')
            ->get();

        $paymentTypes = PaymentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('purchase-orders.create', compact(
            'purchaseTypes',
            'paymentTypes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_number' => [
                'required',
                'string',
                'max:255',
                'unique:purchase_orders,order_number',
            ],
            'purchase_type_id' => [
                'required',
                'exists:purchase_types,id',
            ],
            'payment_type_id' => [
                'required',
                'exists:payment_types,id',
            ],
            'website_url' => ['nullable', 'url', 'max:2000'],
            'payment_url' => ['nullable', 'url', 'max:2048'],
            'purchase_proof' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
            'payment_deadline' => ['nullable', 'date'],
            'warehouse_fee_jpy' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
        ], [
            'customer_name.required' => 'Nama customer wajib diisi.',
            'order_number.required' => 'Nomor order wajib diisi.',
            'order_number.unique' => 'Nomor order sudah pernah digunakan.',
            'purchase_type_id.required' => 'Jenis purchase wajib dipilih.',
            'payment_type_id.required' => 'Jenis pembayaran wajib dipilih.',
            'website_url.url' => 'Link website harus berupa URL yang valid.',
            'payment_url.url' => 'Link payment harus berupa URL yang valid.',
            'purchase_proof.image' => 'Bukti purchase harus berupa gambar.',
            'purchase_proof.mimes' => 'Format bukti hanya JPG, JPEG, atau PNG.',
            'purchase_proof.max' => 'Ukuran gambar maksimal 5 MB.',
            'payment_deadline.date' => 'Deadline pembayaran tidak valid.',
        ]);

        if ($request->hasFile('purchase_proof')) {
            $validated['purchase_proof_path'] = $request
                ->file('purchase_proof')
                ->store('purchase-proofs', 'public');
        }

        unset($validated['purchase_proof']);

        $validated['created_by'] = $request->user()->id;

        PurchaseOrder::create($validated);

        return redirect()
            ->route('purchase-orders.index')
            ->with('success', 'Purchase berhasil disimpan.');
    }
    public function show(PurchaseOrder $purchase)
{
    $purchase->load(['purchaseType', 'paymentType', 'creator']);

    return view('purchase-orders.show', compact('purchase'));
}

public function edit(PurchaseOrder $purchase)
{
    $purchaseTypes = PurchaseType::where('is_active', true)
        ->orderBy('name')
        ->get();

    $paymentTypes = PaymentType::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('purchase-orders.edit', compact(
        'purchase',
        'purchaseTypes',
        'paymentTypes'
    ));
}

public function update(Request $request, PurchaseOrder $purchase)
{
    $validated = $request->validate([
        'customer_name' => ['required', 'string', 'max:255'],
        'order_number' => [
            'required',
            'string',
            'max:255',
            \Illuminate\Validation\Rule::unique('purchase_orders', 'order_number')
                ->ignore($purchase->id),
        ],
        'purchase_type_id' => ['required', 'exists:purchase_types,id'],
        'payment_type_id' => ['required', 'exists:payment_types,id'],
        'website_url' => ['nullable', 'url', 'max:2000'],
        'payment_url' => ['nullable', 'url', 'max:2048'],
        'purchase_proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        'payment_deadline' => ['nullable', 'date'],
        'warehouse_fee_jpy' => [
            'required',
            'numeric',
            'min:0',
            'max:9999999999999.99',
        ],
    ]);

    unset($validated['purchase_proof']);

    if ($request->hasFile('purchase_proof')) {
        $newPath = $request->file('purchase_proof')
            ->store('purchase-proofs', 'public');

        if ($purchase->purchase_proof_path) {
            Storage::disk('public')->delete($purchase->purchase_proof_path);
        }

        $validated['purchase_proof_path'] = $newPath;
    }

    $purchase->update($validated);

    return redirect()
        ->route('purchase-orders.show', $purchase)
        ->with('success', 'Purchase berhasil diperbarui.');
}


public function destroy(PurchaseOrder $purchase)
{
    if ($purchase->purchase_proof_path) {
        Storage::disk('public')->delete($purchase->purchase_proof_path);
    }

    $purchase->delete();

    return redirect()
        ->route('purchase-orders.index')
        ->with('success', 'Purchase berhasil dihapus.');
}
}
