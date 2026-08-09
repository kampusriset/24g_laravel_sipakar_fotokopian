<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Cetak Fotokopi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 600px;">
        
        <!-- [NAVIGASI] Tombol Kembali ke Dashboard -->
        <div class="mb-3">
            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary btn-sm font-weight-bold">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-warning text-dark font-weight-bold py-3">
                <h5 class="mb-0 fw-bold">🖨️ Form Pemesanan & Analisis AI</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo e(route('order.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Nama Pemesan (Otomatis terisi dari nama user login) -->
                    <div class="mb-3">
                        <label class="form-label font-semibold text-secondary">Nama Pemesan</label>
                        <input type="text" name="customer_name" class="form-control" 
                               value="<?php echo e(Auth::check() ? Auth::user()->name : ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-semibold text-secondary">Jumlah Halaman</label>
                        <input type="number" name="total_pages" class="form-control" placeholder="Contoh: 50" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-semibold text-secondary">Jenis Jilid</label>
                        <select name="binding_type" class="form-select">
                            <option value="tanpa_jilid">Tanpa Jilid</option>
                            <option value="staples">Staples</option>
                            <option value="spiral">Spiral</option>
                            <option value="hardcover">Hardcover</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-semibold text-secondary">Tingkat Urgensi (1: Santai - 10: Sangat Urgent)</label>
                        <input type="number" name="urgency_level" min="1" max="10" class="form-control" placeholder="Masukkan angka 1-10" required>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold text-dark py-2 shadow-sm">
                        ⚡ Hitung Antrean & Proses dengan AI
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/order.blade.php ENDPATH**/ ?>