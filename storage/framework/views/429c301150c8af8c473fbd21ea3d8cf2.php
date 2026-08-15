<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan Pelanggan - PUNAZA COPY</title>
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        .glass-card {
            background: #ffffff !important;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            border: 1px solid #cbd5e1;
            overflow: hidden;
        }

        /* Banner Header Hijau Emerald Pekat (Pastikan Teks Selalu Kelihatan) */
        .status-header-banner {
            background: #047857 !important; /* Hijau Emerald Pekat */
            color: #ffffff !important;
            padding: 24px 20px;
            text-align: center;
        }

        .status-badge-header {
            background-color: #065f46 !important;
            color: #fef08a !important; /* Teks Kuning Terang */
            border: 1px solid #34d399 !important;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 14px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .btn-amber {
            background-color: #d97706 !important;
            color: #ffffff !important;
            font-weight: 700;
            border: none;
        }
        .btn-amber:hover {
            background-color: #b45309 !important;
            color: #ffffff !important;
        }

        .estimate-box {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
        }
    </style>
</head>
<body class="pb-5">

    <!-- Header Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 px-3 shadow-sm" style="background-color: #0f172a !important;">
        <div class="container" style="max-width: 580px;">
            <a class="navbar-brand fw-bold text-warning fs-6 d-flex align-items-center gap-2" href="<?php echo e(route('dashboard')); ?>">
                <span>🖨️</span> PUNAZA COPY AI
            </a>
            <div class="d-flex align-items-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-light btn-sm fw-bold rounded-pill">
                        Dashboard
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-warning btn-sm fw-bold rounded-pill text-dark">
                            Admin
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                            Logout
                        </button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-warning btn-sm fw-bold rounded-pill text-dark">Login</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 580px;">
        <div class="glass-card mb-5">
            
            <!-- Header Banner Status Berwarna Hijau Tegas -->
            <div class="status-header-banner">
                <div class="status-badge-header">
                    ⚡ SISTEM ANTREAN CERDAS
                </div>
                <h4 class="mb-1 font-weight-bold text-white" style="font-weight: 800 !important;">Pesanan Berhasil Diterima!</h4>
                <p class="mb-0 small" style="color: #a7f3d0 !important;">Rincian estimasi pengerjaan dan biaya transaksi Anda</p>
            </div>

            <div class="p-4">
                <!-- Nama Pemesan -->
                <div class="text-center mb-3">
                    <span class="text-secondary small text-uppercase font-weight-bold">Atas Nama Pemesan</span>
                    <h4 class="fw-bold text-dark mt-1 mb-0">👤 <?php echo e($order->customer_name); ?></h4>
                </div>

                <hr class="my-3 opacity-25">

                <!-- Estimasi Waktu Selesai -->
                <div class="estimate-box p-3 text-center my-3">
                    <p class="text-secondary mb-1 fs-7 fw-bold text-uppercase">Perkiraan Jam Selesai Cetak</p>
                    <h2 class="text-success fw-bold mb-1 display-6" style="font-weight: 900 !important;">
                        <?php echo e(isset($estimatedFinishTime) ? $estimatedFinishTime->format('H:i') : $order->created_at->addMinutes($totalWaitingMinutes ?? $order->estimated_duration_minutes)->format('H:i')); ?> <span class="fs-5">WIB</span>
                    </h2>
                    <div class="mt-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($totalWaitingMinutes ?? 0) > $order->estimated_duration_minutes): ?>
                            <span class="badge bg-warning text-dark p-2 text-wrap rounded-pill border border-warning" style="font-size: 0.8rem;">
                                <i class="bi bi-clock-history me-1"></i> (Ada antrean lain di depan) • Total tunggu: <strong>±<?php echo e($totalWaitingMinutes); ?> Menit</strong>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success text-white p-2 text-wrap rounded-pill border border-success" style="font-size: 0.8rem;">
                                <i class="bi bi-lightning-fill me-1"></i> Langsung dikerjakan • Estimasi tunggu: <strong>±<?php echo e($order->estimated_duration_minutes); ?> Menit</strong>
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Detail Pesanan & Indikator AI -->
                <ul class="list-group list-group-flush border rounded-3 mb-4 shadow-sm">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Detail Cetak:</span>
                        <strong class="text-dark">
                            <?php echo e($order->total_pages); ?> Halaman (<?php echo e(ucfirst($order->binding_type)); ?>)
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($order->copies ?? 1) > 1): ?>
                                <span class="badge bg-warning text-dark ms-1">
                                    <?php echo e($order->copies); ?>x Copy
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Skor Prioritas AI:</span>
                        <?php
                            $score = $order->priority_score ?? 50;
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($score >= 80): ?>
                            <span class="badge bg-danger text-white fw-bold px-3 py-1.5 rounded-pill">🔥 Tinggi (<?php echo e($score); ?> Poin)</span>
                        <?php elseif($score >= 50): ?>
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 rounded-pill">⚡ Sedang (<?php echo e($score); ?> Poin)</span>
                        <?php else: ?>
                            <span class="badge bg-secondary text-white fw-bold px-3 py-1.5 rounded-pill">☕ Rendah (<?php echo e($score); ?> Poin)</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Status Pesanan:</span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status == 'Selesai'): ?>
                            <span class="badge bg-success px-3 py-1.5 rounded-pill">✅ Selesai (Bisa Diambil)</span>
                        <?php elseif($order->status == 'Diproses'): ?>
                            <span class="badge bg-primary px-3 py-1.5 rounded-pill">⚙️ Sedang Dicetak</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill">⏳ Dalam Antrean AI</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                </ul>

                <!-- Ringkasan Biaya Pembayaran -->
                <div class="card bg-light border-0 rounded-4 text-start mb-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            💳 Ringkasan Pembayaran
                        </h6>
                        
                        <?php
                            $copies = $order->copies ?? 1;
                            $hargaPerHalaman = 300;
                            $biayaCetak = ($order->total_pages * $copies) * $hargaPerHalaman;
                            
                            $biayaJilidSatuan = match($order->binding_type) {
                                'staples' => 2000,
                                'spiral' => 5000,
                                'hardcover' => 15000,
                                default => 0,
                            };
                            
                            $biayaJilidTotal = $biayaJilidSatuan * $copies;
                            $totalBiaya = $biayaCetak + $biayaJilidTotal;
                        ?>

                        <div class="d-flex justify-content-between mb-1 text-secondary small">
                            <span>Biaya Cetak (<?php echo e($order->total_pages); ?> hal x <?php echo e($copies); ?> Copy):</span>
                            <span>Rp <?php echo e(number_format($biayaCetak, 0, ',', '.')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-secondary small">
                            <span>Biaya Jilid (<?php echo e(ucfirst($order->binding_type)); ?> x <?php echo e($copies); ?>):</span>
                            <span>Rp <?php echo e(number_format($biayaJilidTotal, 0, ',', '.')); ?></span>
                        </div>

                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="fw-bold text-dark">Total Biaya:</span>
                            <span class="fw-bold text-success fs-5">Rp <?php echo e(number_format($totalBiaya, 0, ',', '.')); ?></span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small">
                            <span class="text-secondary">Metode Bayar:</span>
                            <span class="fw-bold text-dark"><?php echo e($order->payment_method ?? 'Bayar di Kasir (Tunai/QRIS)'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Utama -->
                <div class="d-grid gap-2 mb-3">
                    <a href="<?php echo e(route('order.nota', $order->id)); ?>" target="_blank" class="btn btn-success fw-bold py-2.5 rounded-3 shadow-sm">
                        🧾 Lihat & Cetak Nota Resmi
                    </a>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-amber py-2.5 rounded-3 shadow-sm">
                        🏠 Ke Dashboard Utama
                    </a>
                    <a href="<?php echo e(route('order.form')); ?>" class="btn btn-outline-secondary rounded-3">
                        🖨️ + Buat Pesanan Lain
                    </a>
                </div>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->check() && auth()->user()->role === 'admin'): ?>
                    <div class="border-top pt-3 mt-3">
                        <small class="text-muted d-block mb-2 text-center">Akses Khusus Toko / Admin:</small>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-dark btn-sm w-100 rounded-3 py-2">
                            ⚡ Buka Worklist Toko (Pilih Pesanan Diprint)
                        </a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/status.blade.php ENDPATH**/ ?>