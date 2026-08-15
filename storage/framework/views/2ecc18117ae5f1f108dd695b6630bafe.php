<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUNAZA COPY - Buat Pesanan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .btn-amber {
            background-color: #d97706 !important;
            color: #ffffff !important;
            font-weight: bold;
        }
        .btn-amber:hover {
            background-color: #b45309 !important;
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <span class="badge bg-warning text-dark font-semibold px-3 py-2 rounded-pill mb-2">⚡ PUNAZA COPY</span>
                    <h3 class="fw-bold text-dark">Formulir Pesanan Cetak</h3>
                    <p class="text-muted small">Sistem akan otomatis menghitung estimasi waktu pengerjaan dokumenmu.</p>
                </div>

                <form action="<?php echo e(route('order.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Nama Pemesan</label>
                        <input type="text" name="customer_name" class="form-control form-control-lg rounded-3 fs-6" required placeholder="Masukkan nama kamu...">
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold text-secondary">Jumlah Halaman</label>
                            <input type="number" name="total_pages" class="form-control rounded-3" min="1" required placeholder="Contoh: 50">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold text-secondary">Jumlah Eksemplar</label>
                            <input type="number" name="copies" class="form-control rounded-3" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Jenis Jilid</label>
                        <select name="binding_type" class="form-select rounded-3" required>
                            <option value="tanpa_jilid">Tanpa Jilid</option>
                            <option value="staples">Staples</option>
                            <option value="spiral">Spiral</option>
                            <option value="hardcover">Hardcover</option>
                        </select>
                    </div>

                    <!-- Input Angka Tingkat Ketergesaan (Urgensi 1-10) -->
                    <div class="mb-3">
                        <label for="urgency_level" class="form-label fw-bold text-secondary">Tingkat Ketergesaan (Urgensi 1-10)</label>
                        <input 
                            type="number" 
                            name="urgency_level" 
                            id="urgency_level" 
                            class="form-control rounded-3" 
                            min="1" 
                            max="10" 
                            placeholder="Ketik angka 1 sampai 10..." 
                            value="<?php echo e(old('urgency_level', 5)); ?>" 
                            required
                        >
                        <small class="text-muted d-block mt-1">*Ketik angka 1 (Biasa/Santai) hingga 10 (Sangat Urgent/Terburu-buru).</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select rounded-3" required>
                            <option value="Bayar di Kasir (Tunai/QRIS)">Bayar di Kasir (Tunai/QRIS)</option>
                            <option value="Transfer Bank / E-Wallet">Transfer Bank / E-Wallet</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-amber btn-lg w-100 rounded-3 py-3 shadow-sm mb-2">
                        🚀 Kirim Pesanan & Hitung Estimasi
                    </button>

                    <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-outline-secondary w-100 rounded-3">
                        ⬅️ Kembali ke Dashboard
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/order.blade.php ENDPATH**/ ?>