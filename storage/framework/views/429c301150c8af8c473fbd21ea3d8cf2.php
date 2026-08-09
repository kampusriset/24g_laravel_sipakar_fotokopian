<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm border-bottom mb-4">
        <div class="container" style="max-width: 520px;">
            <a class="navbar-brand fw-bold text-dark fs-6" href="<?php echo e(route('dashboard')); ?>">
                🖨️ Antrean Fotokopi AI
            </a>
            <div class="d-flex align-items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <!-- [DITAMBAHKAN] Tombol Ke Dashboard untuk Pelanggan -->
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary btn-sm fw-bold">
                        Dashboard
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-dark btn-sm font-semibold">
                            Admin
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-sm">Login</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 520px;">
        <div class="card shadow border-0 text-center mb-5">
            <div class="card-header bg-success text-white py-3">
                <h4 class="mb-0 fw-bold">Pesanan Berhasil Diterima!</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-1">Nama Pemesan</p>
                <h5 class="fw-bold"><?php echo e($order->customer_name); ?></h5>
                <hr>

                <div class="bg-light p-3 rounded my-3 border">
                    <p class="text-muted mb-1 fs-6">Estimasi Selesai & Siap Diambil</p>
                    <h2 class="text-success fw-bold mb-1">
                        <?php echo e($order->created_at->addMinutes($totalWaitingMinutes ?? $order->estimated_duration_minutes)->format('H:i')); ?> WIB
                    </h2>
                    <small class="text-muted">
                        Lama pengerjaan: <strong><?php echo e($order->estimated_duration_minutes); ?> Menit</strong>
                    </small>
                </div>

                <ul class="list-group list-group-flush text-start mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Detail Cetak:</span>
                        <strong><?php echo e($order->total_pages); ?> Halaman (<?php echo e($order->binding_type); ?>)</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Skor Prioritas AI:</span>
                        <span class="badge bg-info text-dark fw-bold"><?php echo e($order->priority_score ?? 'Auto'); ?> Poin</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Status Pesanan:</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status == 'Selesai'): ?>
                            <span class="badge bg-success">Selesai</span>
                        <?php elseif($order->status == 'Diproses'): ?>
                            <span class="badge bg-primary">Sedang Dicetak</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Dalam Antrean AI</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                </ul>

                <!-- [DITAMBAHKAN] Tombol Ganda: Ke Dashboard & Buat Pesanan Baru -->
                <div class="d-grid gap-2 mb-3">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-warning fw-bold text-dark">
                        🏠 Ke Dashboard Utama
                    </a>
                    <a href="<?php echo e(route('order.form')); ?>" class="btn btn-outline-primary">
                        🖨️ + Buat Pesanan Lain
                    </a>
                </div>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
                    <div class="border-top pt-3 mt-3">
                        <small class="text-muted d-block mb-2">Akses Khusus Toko / Admin:</small>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-dark btn-sm w-100">
                            ⚡ Buka Worklist Toko (Pilih Pesanan Diprint)
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/status.blade.php ENDPATH**/ ?>