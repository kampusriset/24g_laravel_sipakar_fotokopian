<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 520px;">
        <div class="card shadow border-0 text-center">
            <div class="card-header bg-success text-white py-3">
                <h4 class="mb-0 fw-bold">Pesanan Berhasil Diterima!</h4>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-1">Nama Pemesan</p>
                <h5 class="fw-bold">{{ $order->customer_name }}</h5>
                <hr>

                <div class="bg-light p-3 rounded my-3 border">
                    <p class="text-muted mb-1 fs-6">Estimasi Selesai & Siap Diambil</p>
                    <h2 class="text-success fw-bold mb-1">
                        {{ $order->created_at->addMinutes($totalWaitingMinutes ?? $order->estimated_duration_minutes)->format('H:i') }} WIB
                    </h2>
                    <small class="text-muted">
                        Lama pengerjaan: <strong>{{ $order->estimated_duration_minutes }} Menit</strong>
                    </small>
                </div>

                <ul class="list-group list-group-flush text-start mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Detail Cetak:</span>
                        <strong>{{ $order->total_pages }} Halaman ({{ $order->binding_type }})</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Skor Prioritas AI:</span>
                        <span class="badge bg-info text-dark fw-bold">{{ $order->priority_score ?? 'Auto' }} Poin</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Status Pesanan:</span>
                        @if($order->status == 'Selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($order->status == 'Diproses')
                            <span class="badge bg-primary">Sedang Dicetak</span>
                        @else
                            <span class="badge bg-warning text-dark">Dalam Antrean AI</span>
                        @endif
                    </li>
                </ul>

                <a href="{{ route('order.form') }}" class="btn btn-outline-primary w-100 mb-3">Buat Pesanan Lain</a>
                
                {{-- Tombol ini HANYA tampil jika yang login punya role 'admin' --}}
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="border-top pt-3">
                        <small class="text-muted d-block mb-2">Akses Khusus Toko / Admin:</small>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm w-100">
                            ⚡ Buka Worklist Toko (Pilih Pesanan Diprint)
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>