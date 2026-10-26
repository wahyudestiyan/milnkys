<?php

namespace App\Http\Controllers;

use App\Models\PurchaseType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseTypeController extends Controller
{
    public function index(): View
    {
        $purchaseTypes = PurchaseType::query()
            ->orderBy('name')
            ->get();

        return view('purchase-types.index', compact('purchaseTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:purchase_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        PurchaseType::create($validated);

        return redirect()
            ->route('purchase-types.index')
            ->with('success', 'Jenis purchase berhasil ditambahkan.');
    }

    public function update(Request $request, PurchaseType $purchaseType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:purchase_types,name,' . $purchaseType->id,
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $purchaseType->update($validated);

        return redirect()
            ->route('purchase-types.index')
            ->with('success', 'Jenis purchase berhasil diperbarui.');
    }

    public function destroy(PurchaseType $purchaseType): RedirectResponse
    {
        $purchaseType->delete();

        return redirect()
            ->route('purchase-types.index')
            ->with('success', 'Jenis purchase berhasil dihapus.');
    }
}
