<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes - PUNAZA COPY
|--------------------------------------------------------------------------
*/

// 1. Redirect Halaman Utama ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Route Dashboard Pelanggan
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Route Fitur Pelanggan (Form Order, Status Pesanan & Nota)
Route::middleware(['auth'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('order.form');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/status/{id}', [OrderController::class, 'status'])->name('order.status');
    
    // Route melihat & mencetak Nota Terpisah
    Route::get('/order/nota/{id}', function ($id) {
        $order = Order::findOrFail($id);
        return view('nota', compact('order'));
    })->name('order.nota');
});

// 4. Route Fitur Admin (Worklist Toko, CRUD Status, Export Excel & PDF)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard Admin / Worklist Toko
    Route::get('/', [OrderController::class, 'admin'])->name('admin.dashboard');
    
    // Update Status Pesanan (PATCH)
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.updateStatus');
    
    // Hapus Pesanan (DELETE)
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('admin.deleteOrder');
    
    // Export Excel & PDF
    Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('admin.exportExcel');
    Route::get('/export-pdf', [OrderController::class, 'exportPdf'])->name('admin.exportPdf');
});

// 5. Route Login dengan Google (Socialite)
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();
        
        $user = User::updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId() ?? null,
            'password' => bcrypt(Str::random(16)),
        ]);

        Auth::login($user);
        
        return redirect()->route('dashboard');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Gagal login via Google.');
    }
});

// Route Autentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';