<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExchangeRateController extends Controller
{
    public function index(): View
    {
        $exchangeRate = ExchangeRate::current();

        return view('exchange-rates.index', compact('exchangeRate'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rate' => ['required', 'numeric', 'gt:0', 'max:999999999999'],
        ], [
    'rate.required' => 'Kurs wajib diisi.',
    'rate.numeric' => 'Kurs harus berupa angka.',
    'rate.gt' => 'Kurs harus lebih besar dari nol.',
    'rate.max' => 'Nilai kurs terlalu besar.',
]);

        ExchangeRate::query()
            ->where('from_currency', 'JPY')
            ->where('to_currency', 'IDR')
            ->update(['is_active' => false]);

        ExchangeRate::create([
            'from_currency' => 'JPY',
            'to_currency' => 'IDR',
            'rate' => $validated['rate'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('exchange-rates.index')
            ->with('success', 'Kurs JPY ke IDR berhasil diperbarui.');
    }
}
