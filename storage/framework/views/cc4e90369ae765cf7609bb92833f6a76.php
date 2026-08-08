<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Antrean Pesanan - PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-4" onload="window.print()">
    <div class="text-center mb-4">
        <h3 class="fw-bold">LAPORAN JADWAL PRIORITAS PENGERJAAN</h3>
        <p class="text-muted mb-0">Sistem Antrean Percetakan / Fotokopi</p>
        <hr>
    </div>

    <div class="mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak / Simpan PDF</button>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <table class="table table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Detail Pesanan</th>
                <th>Tingkat Ketergesaan</th>
                <th>Lama Pengerjaan</th>
                <th>Nilai Prioritas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>#<?php echo e($index + 1); ?></td>
                <td class="text-start ps-2"><?php echo e($order->customer_name); ?></td>
                <td class="text-start ps-2"><?php echo e($order->total_pages); ?> hlm (<?php echo e($order->binding_type); ?>)</td>
                <td><?php echo e($order->urgency_level); ?></td>
                <td><?php echo e($order->estimated_duration_minutes); ?> Mnt</td>
                <td><?php echo e($order->priority_score); ?></td>
                <td><?php echo e($order->status); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\laragon\www\fotokopi111\resources\views/admin_pdf.blade.php ENDPATH**/ ?>