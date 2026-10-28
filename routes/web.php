<?php

use Illuminate\Support\Facades\Route;
use App\Models\PurchaseOrder;
use App\Models\ArrivedItem;
use App\Models\ShipmentBatch;
use Illuminate\Support\Collection;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\PurchaseTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ArrivedItemController;
use App\Http\Controllers\ShipmentBatchController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ThemeController;

// Login: hanya untuk pengguna yang belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Semua route berikut wajib login
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard dapat diakses semua pengguna yang sudah login
    
    // Dashboard dapat diakses semua pengguna yang sudah login
    Route::get('/', function () {

        // 5 pesanan terbaru
        $pesanan = PurchaseOrder::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'icon' => '🛍️',
                    'judul' => 'Input Purchase dilakukan',
                    'keterangan' => 'Pesanan ' . ($item->order_number ?? '-')
                        . ' · ' . ($item->customer_name ?? '-'),
                    'tanggal' => $item->created_at,
                ];
            });

        // 5 barang tiba terbaru
        $barangTiba = ArrivedItem::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'icon' => '📦',
                    'judul' => 'Input Arrived dilakukan',
                    'keterangan' => 'Resi ' . ($item->tracking_number ?? '-'),
                    'tanggal' => $item->created_at,
                ];
            });

        // 5 batch pengiriman terbaru
        $batchPengiriman = ShipmentBatch::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'icon' => '🚚',
                    'judul' => $item->is_closed
                        ? 'Batch pengiriman ditutup'
                        : 'Batch pengiriman dibuat',
                    'keterangan' => $item->name,
                    'tanggal' => $item->closed_at ?? $item->created_at,
                ];
            });

        // Gabungkan semua aktivitas dan ambil 5 terbaru
        $aktivitasTerbaru = $pesanan
            ->concat($barangTiba)
            ->concat($batchPengiriman)
            ->sortByDesc('tanggal')
            ->take(5)
            ->values();

        return view('dashboard', compact('aktivitasTerbaru'));

    })->name('dashboard');


    // Khusus admin
    Route::middleware('role:admin')->group(function () {

        // Pengaturan kurs mata uang
        Route::get('/pengaturan/kurs', [ExchangeRateController::class, 'index'])
            ->name('exchange-rates.index');

        Route::post('/pengaturan/kurs', [ExchangeRateController::class, 'update'])
            ->name('exchange-rates.update');

        // Pengaturan jenis purchase
        Route::get('/pengaturan/jenis-purchase', [PurchaseTypeController::class, 'index'])
            ->name('purchase-types.index');

        Route::post('/pengaturan/jenis-purchase', [PurchaseTypeController::class, 'store'])
            ->name('purchase-types.store');

        Route::put('/pengaturan/jenis-purchase/{purchaseType}', [PurchaseTypeController::class, 'update'])
            ->name('purchase-types.update');

        Route::delete('/pengaturan/jenis-purchase/{purchaseType}', [PurchaseTypeController::class, 'destroy'])
            ->name('purchase-types.destroy');

        // Pengaturan jenis payment
        Route::get('/pengaturan/jenis-payment', [PaymentTypeController::class, 'index'])
            ->name('payment-types.index');

        Route::post('/pengaturan/jenis-payment', [PaymentTypeController::class, 'store'])
            ->name('payment-types.store');

        Route::put('/pengaturan/jenis-payment/{paymentType}', [PaymentTypeController::class, 'update'])
            ->name('payment-types.update');

        Route::delete('/pengaturan/jenis-payment/{paymentType}', [PaymentTypeController::class, 'destroy'])
            ->name('payment-types.destroy');

        // Pengelolaan akun karyawan
        Route::get('/pengaturan/akun-karyawan', [EmployeeController::class, 'index'])
            ->name('employees.index');

        Route::post('/pengaturan/akun-karyawan', [EmployeeController::class, 'store'])
            ->name('employees.store');

        Route::put('/pengaturan/akun-karyawan/{employee}', [EmployeeController::class, 'update'])
            ->name('employees.update');

        Route::delete('/pengaturan/akun-karyawan/{employee}', [EmployeeController::class, 'destroy'])
            ->name('employees.destroy');


                // Transaksi Purchase
        Route::get('/purchase', [PurchaseOrderController::class, 'index'])
            ->name('purchase-orders.index');

        Route::get('/purchase/create', [PurchaseOrderController::class, 'create'])
            ->name('purchase-orders.create');

        Route::post('/purchase', [PurchaseOrderController::class, 'store'])
            ->name('purchase-orders.store');

            Route::get('/purchase/{purchase}', [PurchaseOrderController::class, 'show'])
            ->name('purchase-orders.show');

        Route::get('/purchase/{purchase}/edit', [PurchaseOrderController::class, 'edit'])
            ->name('purchase-orders.edit');

        Route::put('/purchase/{purchase}', [PurchaseOrderController::class, 'update'])
            ->name('purchase-orders.update');

        Route::delete('/purchase/{purchase}', [PurchaseOrderController::class, 'destroy'])
            ->name('purchase-orders.destroy');

        
        Route::get('/pengiriman-indonesia', [ShipmentBatchController::class, 'index'])
            ->name('shipment-batches.index');

        Route::post('/pengiriman-indonesia', [ShipmentBatchController::class, 'store'])
            ->name('shipment-batches.store');

        Route::get('/pengiriman-indonesia/{shipmentBatch}', [ShipmentBatchController::class, 'show'])
            ->name('shipment-batches.show');

        Route::patch('/pengiriman-indonesia/{shipmentBatch}/tutup', [ShipmentBatchController::class, 'close'])
            ->name('shipment-batches.close');
        Route::delete(
                '/pengiriman-indonesia/{shipmentBatch}',
                [ShipmentBatchController::class, 'destroy']
            )->name('shipment-batches.destroy');
            Route::get(
                '/pengiriman-indonesia/{shipmentBatch}/edit',
                [ShipmentBatchController::class, 'edit']
            )->name('shipment-batches.edit');

            Route::put(
                '/pengiriman-indonesia/{shipmentBatch}',
                [ShipmentBatchController::class, 'update']
            )->name('shipment-batches.update');
            Route::patch(
                '/pengiriman-indonesia/{shipmentBatch}/buka',
                [ShipmentBatchController::class, 'reopen']
            )->name('shipment-batches.reopen');

        // Pengaturan tema aplikasi
        Route::get('/pengaturan/tema', [ThemeController::class, 'index'])
            ->name('theme-settings.index');

        Route::put('/pengaturan/tema', [ThemeController::class, 'update'])
            ->name('theme-settings.update');
    });

        // Profil pengguna: ubah nama, email, dan password
    Route::get('/profil', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');

        
// Barang Tiba / Arrived Items
Route::get('/barang-tiba', [ArrivedItemController::class, 'index'])
    ->name('arrived-items.index');

Route::get('/barang-tiba/create', [ArrivedItemController::class, 'create'])
    ->name('arrived-items.create');

Route::post('/barang-tiba', [ArrivedItemController::class, 'store'])
    ->name('arrived-items.store');

Route::get('/barang-tiba/{arrivedItem}/edit', [ArrivedItemController::class, 'edit'])
    ->name('arrived-items.edit');

Route::get('/barang-tiba/{arrivedItem}', [ArrivedItemController::class, 'show'])
    ->name('arrived-items.show');

Route::put('/barang-tiba/{arrivedItem}', [ArrivedItemController::class, 'update'])
    ->name('arrived-items.update');

Route::delete('/barang-tiba/{arrivedItem}', [ArrivedItemController::class, 'destroy'])
    ->name('arrived-items.destroy');

//rekap pengiriman
    Route::get('/rekap-pengiriman', [
    \App\Http\Controllers\ShipmentBatchController::class,
    'recap'
])->name('shipment-batches.recap');


Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])
    ->name('laporan.pdf');

Route::get('/laporan/excel', [LaporanController::class, 'excel'])
    ->name('laporan.excel');

});
