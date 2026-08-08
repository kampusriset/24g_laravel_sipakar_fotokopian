<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect Halaman Utama ke Form Pemesanan
Route::get('/', function () {
    return redirect()->route('order.form');
});

// 2. Route Fitur Pelanggan (Form Order & Status Pesanan)
Route::get('/order', [OrderController::class, 'index'])->name('order.form');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/status/{id}', [OrderController::class, 'status'])->name('order.status');

// 3. Route Fitur Admin (CRUD Worklist, Export Excel & Export PDF)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [OrderController::class, 'admin'])->name('admin.dashboard');
    
    // Update Status Pesanan (PATCH)
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.updateStatus');
    
    // Hapus Pesanan (DELETE)
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('admin.deleteOrder');
    
    // Export Excel (GET)
    Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('admin.exportExcel');
    
    // Export PDF (GET) - TAMBAHAN
    Route::get('/export-pdf', [OrderController::class, 'exportPdf'])->name('admin.exportPdf');
});

// Route Autentikasi Bawaan Laravel Breeze / Jetstream
require __DIR__.'/auth.php';