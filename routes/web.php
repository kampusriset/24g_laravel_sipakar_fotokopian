<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect Halaman Utama (Buka Web Langsung ke Login / Dashboard)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Route Dashboard Pelanggan [DITAMBAHKAN BIAR GAK ERROR LAGI]
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Route Fitur Pelanggan (Form Order & Status Pesanan)
Route::middleware(['auth'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('order.form');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/status/{id}', [OrderController::class, 'status'])->name('order.status');
});

// 4. Route Fitur Admin (CRUD Worklist, Export Excel & Export PDF)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [OrderController::class, 'admin'])->name('admin.dashboard');
    
    // Update Status Pesanan (PATCH)
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.updateStatus');
    
    // Hapus Pesanan (DELETE)
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('admin.deleteOrder');
    
    // Export Excel (GET)
    Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('admin.exportExcel');
    
    // Export PDF (GET)
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
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'google_id' => $googleUser->id ?? null,
            'password' => bcrypt(rand(100000, 999999)),
        ]);

        Auth::login($user);
        
        // Diarahkan langsung ke Dashboard Pelanggan setelah login Google
        return redirect()->route('dashboard');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Gagal login via Google.');
    }
});

// Route Autentikasi Bawaan Laravel Breeze / Jetstream
require __DIR__.'/auth.php';