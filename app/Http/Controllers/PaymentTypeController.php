<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentTypeController extends Controller
{
    public function index(): View
    {
        $paymentTypes = PaymentType::query()
            ->orderBy('name')
            ->get();

        return view('payment-types.index', compact('paymentTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:payment_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        PaymentType::create($validated);

        return redirect()
            ->route('payment-types.index')
            ->with('success', 'Jenis payment berhasil ditambahkan.');
    }

    public function update(Request $request, PaymentType $paymentType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:payment_types,name,' . $paymentType->id,
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $paymentType->update($validated);

        return redirect()
            ->route('payment-types.index')
            ->with('success', 'Jenis payment berhasil diperbarui.');
    }

    public function destroy(PaymentType $paymentType): RedirectResponse
    {
        $paymentType->delete();

        return redirect()
            ->route('payment-types.index')
            ->with('success', 'Jenis payment berhasil dihapus.');
    }
}
