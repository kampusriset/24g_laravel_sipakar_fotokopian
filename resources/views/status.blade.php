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
            <a class="navbar-brand fw-bold text-warning fs-6 d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <span>🖨️</span> PUNAZA COPY AI
            </a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm fw-bold rounded-pill">
                        Dashboard
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm fw-bold rounded-pill text-dark">
                            Admin
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning btn-sm fw-bold rounded-pill text-dark">Login</a>
                @endauth
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
                    <h4 class="fw-bold text-dark mt-1 mb-0">👤 {{ $order->customer_name }}</h4>
                </div>

                <hr class="my-3 opacity-25">

                <!-- Estimasi Waktu Selesai -->
                <div class="estimate-box p-3 text-center my-3">
                    <p class="text-secondary mb-1 fs-7 fw-bold text-uppercase">Perkiraan Jam Selesai Cetak</p>
                    <h2 class="text-success fw-bold mb-1 display-6" style="font-weight: 900 !important;">
                        {{ isset($estimatedFinishTime) ? $estimatedFinishTime->format('H:i') : $order->created_at->addMinutes($totalWaitingMinutes ?? $order->estimated_duration_minutes)->format('H:i') }} <span class="fs-5">WIB</span>
                    </h2>
                    <div class="mt-2">
                        @if(($totalWaitingMinutes ?? 0) > $order->estimated_duration_minutes)
                            <span class="badge bg-warning text-dark p-2 text-wrap rounded-pill border border-warning" style="font-size: 0.8rem;">
                                <i class="bi bi-clock-history me-1"></i> (Ada antrean lain di depan) • Total tunggu: <strong>±{{ $totalWaitingMinutes }} Menit</strong>
                            </span>
                        @else
                            <span class="badge bg-success text-white p-2 text-wrap rounded-pill border border-success" style="font-size: 0.8rem;">
                                <i class="bi bi-lightning-fill me-1"></i> Langsung dikerjakan • Estimasi tunggu: <strong>±{{ $order->estimated_duration_minutes }} Menit</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detail Pesanan & Indikator AI -->
                <ul class="list-group list-group-flush border rounded-3 mb-4 shadow-sm">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Detail Cetak:</span>
                        <strong class="text-dark">
                            {{ $order->total_pages }} Halaman ({{ ucfirst($order->binding_type) }})
                            @if(($order->copies ?? 1) > 1)
                                <span class="badge bg-warning text-dark ms-1">
                                    {{ $order->copies }}x Copy
                                </span>
                            @endif
                        </strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Skor Prioritas AI:</span>
                        @php
                            $score = $order->priority_score ?? 50;
                        @endphp
                        @if($score >= 80)
                            <span class="badge bg-danger text-white fw-bold px-3 py-1.5 rounded-pill">🔥 Tinggi ({{ $score }} Poin)</span>
                        @elseif($score >= 50)
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 rounded-pill">⚡ Sedang ({{ $score }} Poin)</span>
                        @else
                            <span class="badge bg-secondary text-white fw-bold px-3 py-1.5 rounded-pill">☕ Rendah ({{ $score }} Poin)</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-secondary">Status Pesanan:</span>
                        @if($order->status == 'Selesai')
                            <span class="badge bg-success px-3 py-1.5 rounded-pill">✅ Selesai (Bisa Diambil)</span>
                        @elseif($order->status == 'Diproses')
                            <span class="badge bg-primary px-3 py-1.5 rounded-pill">⚙️ Sedang Dicetak</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill">⏳ Dalam Antrean AI</span>
                        @endif
                    </li>
                </ul>

                <!-- Ringkasan Biaya Pembayaran -->
                <div class="card bg-light border-0 rounded-4 text-start mb-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            💳 Ringkasan Pembayaran
                        </h6>
                        
                        @php
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
                        @endphp

                        <div class="d-flex justify-content-between mb-1 text-secondary small">
                            <span>Biaya Cetak ({{ $order->total_pages }} hal x {{ $copies }} Copy):</span>
                            <span>Rp {{ number_format($biayaCetak, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-secondary small">
                            <span>Biaya Jilid ({{ ucfirst($order->binding_type) }} x {{ $copies }}):</span>
                            <span>Rp {{ number_format($biayaJilidTotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="fw-bold text-dark">Total Biaya:</span>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small">
                            <span class="text-secondary">Metode Bayar:</span>
                            <span class="fw-bold text-dark">{{ $order->payment_method ?? 'Bayar di Kasir (Tunai/QRIS)' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Utama -->
                <div class="d-grid gap-2 mb-3">
                    <a href="{{ route('order.nota', $order->id) }}" target="_blank" class="btn btn-success fw-bold py-2.5 rounded-3 shadow-sm">
                        🧾 Lihat & Cetak Nota Resmi
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-amber py-2.5 rounded-3 shadow-sm">
                        🏠 Ke Dashboard Utama
                    </a>
                    <a href="{{ route('order.form') }}" class="btn btn-outline-secondary rounded-3">
                        🖨️ + Buat Pesanan Lain
                    </a>
                </div>
                
                {{-- Akses Khusus Toko / Admin --}}
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="border-top pt-3 mt-3">
                        <small class="text-muted d-block mb-2 text-center">Akses Khusus Toko / Admin:</small>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm w-100 rounded-3 py-2">
                            ⚡ Buka Worklist Toko (Pilih Pesanan Diprint)
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>