<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Prioritas Pengerjaan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header / Navbar Status Login & Logout -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Admin Panel Fotokopi</a>
            <div class="d-flex align-items-center gap-3 text-white">
                <span class="small">Halo, <strong><?php echo e(Auth::user()->name ?? 'Admin'); ?></strong></span>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-light btn-sm">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <h2 class="mb-4 fw-bold">Jadwal Prioritas Pengerjaan</h2>
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Area Tombol Aksi (Tambah, Export Excel & Export PDF) -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="<?php echo e(route('order.form')); ?>" class="btn btn-primary fw-semibold">+ Tambah Pesanan Baru</a>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.exportExcel')); ?>" class="btn btn-success fw-semibold">📥 Export Excel</a>
                <a href="<?php echo e(route('admin.exportPdf')); ?>" target="_blank" class="btn btn-danger fw-semibold">📄 Export PDF</a>
            </div>
        </div>
        
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-bordered align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Urutan AI</th>
                        <th>Nama Pemesan</th>
                        <th>Detail Pesanan</th>
                        <th>Tingkat Ketergesaan</th>
                        <th>Lama Pengerjaan</th>
                        <th>Nilai Prioritas</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><span class="badge bg-danger fs-6">#<?php echo e($index + 1); ?></span></td>
                        <td class="text-start ps-3 fw-semibold"><?php echo e($order->customer_name); ?></td>
                        <td class="text-start ps-3"><?php echo e($order->total_pages); ?> hlm (<?php echo e($order->binding_type); ?>)</td>
                        
                        <td>
                            <?php if($order->urgency_level >= 6): ?>
                                <span class="badge bg-danger">Sangat Urgent</span>
                            <?php elseif($order->urgency_level >= 3): ?>
                                <span class="badge bg-warning text-dark">Penting</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Biasa</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($order->estimated_duration_minutes <= 15): ?>
                                <span class="badge bg-info text-dark">Cepat (<?php echo e($order->estimated_duration_minutes); ?> Mnt)</span>
                            <?php elseif($order->estimated_duration_minutes <= 45): ?>
                                <span class="badge bg-primary">Sedang (<?php echo e($order->estimated_duration_minutes); ?> Mnt)</span>
                            <?php else: ?>
                                <span class="badge bg-dark">Lama (<?php echo e($order->estimated_duration_minutes); ?> Mnt)</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($order->priority_score >= 60): ?>
                                <span class="badge bg-secondary fs-6">Tinggi (<?php echo e($order->priority_score); ?>)</span>
                            <?php elseif($order->priority_score >= 30): ?>
                                <span class="badge bg-secondary fs-6">Sedang (<?php echo e($order->priority_score); ?>)</span>
                            <?php else: ?>
                                <span class="badge bg-secondary fs-6">Rendah (<?php echo e($order->priority_score); ?>)</span>
                            <?php endif; ?>
                        </td>

                        <td style="width: 160px;">
                            <form action="<?php echo e(route('admin.updateStatus', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm fw-semibold">
                                    <option value="Dalam Antrean AI" <?php echo e($order->status == 'Dalam Antrean AI' ? 'selected' : ''); ?>>Dalam Antrean AI</option>
                                    <option value="Diproses" <?php echo e($order->status == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                                    <option value="Selesai" <?php echo e($order->status == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                </select>
                            </form>
                        </td>

                        <td>
                            <form action="<?php echo e(route('admin.deleteOrder', $order->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan <?php echo e($order->customer_name); ?>?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-muted py-4">Belum ada pesanan masuk.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/admin.blade.php ENDPATH**/ ?>