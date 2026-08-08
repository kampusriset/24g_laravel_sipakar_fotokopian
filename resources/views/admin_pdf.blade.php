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
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
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
            @foreach($orders as $index => $order)
            <tr>
                <td>#{{ $index + 1 }}</td>
                <td class="text-start ps-2">{{ $order->customer_name }}</td>
                <td class="text-start ps-2">{{ $order->total_pages }} hlm ({{ $order->binding_type }})</td>
                <td>{{ $order->urgency_level }}</td>
                <td>{{ $order->estimated_duration_minutes }} Mnt</td>
                <td>{{ $order->priority_score }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>