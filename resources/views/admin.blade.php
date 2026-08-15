<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Prioritas Pengerjaan - Admin Panel</title>
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Modern Dark Command Center Theme */
        body {
            background: #0f172a !important;
            min-height: 100vh;
            color: #f8fafc !important;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Glassmorphism Card Effect */
        .glass-card {
            background: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .stat-card {
            background: #1e293b !important;
            border-radius: 16px;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        /* Badge Custom Warna Jelas & Terang */
        .badge-urgent-danger {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        .badge-urgent-warning {
            background-color: #f59e0b !important;
            color: #000000 !important;
            font-weight: 700 !important;
        }

        .badge-urgent-secondary {
            background-color: #475569 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }

        .badge-info-blue {
            background-color: #0284c7 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        .badge-rank-1 {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.5);
        }

        /* Form Select Custom Dark */
        .form-select-dark {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 1px solid #475569 !important;
            font-size: 0.8rem !important;
            padding: 6px 28px 6px 10px !important;
            width: 100% !important;
            min-width: 140px !important;
        }
        .form-select-dark:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.25) !important;
        }
    </style>
</head>
<body class="pb-5">

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary border-opacity-25 mb-4 px-4 shadow-lg sticky-top" style="background-color: #0f172a;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-warning d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <span class="fs-4">⚡</span> 
                <span>PUNAZA COPY - Admin Panel</span>
            </a>
            
            <div class="d-flex align-items-center gap-3 text-white">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-warning btn-sm rounded-pill fw-bold">
                    <i class="bi bi-house me-1"></i> Mode Pelanggan
                </a>
                
                <span class="small border-start border-secondary ps-3 ms-1 border-opacity-50 text-slate-300">
                    Halo, <strong class="text-white">{{ Auth::user()->name ?? 'Admin Percetakan' }}</strong>
                </span>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5">
        
        <!-- CARD RINGKASAN STATISTIK DASHBOARD -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card border-0 border-start border-primary border-4 p-3 glass-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary fw-bold text-uppercase small">Total Pesanan</span>
                            <h2 class="fw-bold mb-0 text-white display-6">{{ count($orders) }}</h2>
                        </div>
                        <div class="fs-1 bg-primary bg-opacity-20 p-2 rounded-3">📦</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card border-0 border-start border-warning border-4 p-3 glass-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-warning fw-bold text-uppercase small">Perlu Diproses</span>
                            <h2 class="fw-bold mb-0 text-warning display-6">
                                {{ $orders->whereIn('status', ['Dalam Antrean AI', 'Dalam Antrean', 'Diproses'])->count() }}
                            </h2>
                        </div>
                        <div class="fs-1 bg-warning bg-opacity-20 p-2 rounded-3">⏳</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card border-0 border-start border-success border-4 p-3 glass-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-success fw-bold text-uppercase small">Pesanan Selesai</span>
                            <h2 class="fw-bold mb-0 text-success display-6">
                                {{ $orders->where('status', 'Selesai')->count() }}
                            </h2>
                        </div>
                        <div class="fs-1 bg-success bg-opacity-20 p-2 rounded-3">✅</div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 text-white" style="background-color: #059669;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- TABEL UTAMA WORKLIST -->
        <div class="glass-card p-4">
            
            <!-- Header & Tombol Aksi -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3 border-bottom border-secondary border-opacity-25 pb-3">
                <div>
                    <h3 class="fw-bold mb-1 text-white">⚙️ Jadwal Prioritas Pengerjaan</h3>
                    <p class="text-secondary small mb-0">Urutan antrean diurutkan otomatis oleh <strong class="text-warning">Sistem Pakar Fuzzy Logic + FIFO</strong>.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('order.form') }}" class="btn btn-primary btn-sm fw-bold px-3 py-2 rounded-3">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pesanan
                    </a>
                    <a href="{{ route('admin.exportExcel') }}" class="btn btn-success btn-sm fw-bold px-3 py-2 rounded-3">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                    </a>
                    <a href="{{ route('admin.exportPdf') }}" target="_blank" class="btn btn-danger btn-sm fw-bold px-3 py-2 rounded-3">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>

            <!-- Table Responsive -->
            <div class="table-responsive rounded-3 border border-secondary border-opacity-25">
                <table class="table table-dark align-middle text-center mb-0">
                    <thead class="table-dark text-uppercase small text-secondary">
                        <tr>
                            <th class="py-3">Urutan AI</th>
                            <th class="py-3 text-start ps-3">Nama Pemesan</th>
                            <th class="py-3 text-start ps-3">Detail Pesanan</th>
                            <th class="py-3">Tingkat Ketergesaan</th>
                            <th class="py-3">Lama Pengerjaan</th>
                            <th class="py-3">Nilai Prioritas AI</th>
                            <th class="py-3">Status Pesanan</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr class="border-bottom border-secondary border-opacity-25">
                            
                            <!-- Urutan AI -->
                            <td>
                                <span class="badge {{ $index == 0 ? 'badge-rank-1' : 'bg-secondary' }} fs-6 px-3 py-1.5 rounded-pill">
                                    #{{ $index + 1 }}
                                </span>
                            </td>

                            <!-- Nama Pemesan -->
                            <td class="text-start ps-3 fw-bold text-white">
                                👤 {{ $order->customer_name }}
                            </td>

                            <!-- Detail Pesanan -->
                            <td class="text-start ps-3">
                                <span class="fw-semibold text-white">{{ $order->total_pages }} hlm</span> 
                                <span class="text-secondary">({{ $order->binding_type }})</span>
                                @if(($order->copies ?? 1) > 1)
                                    <span class="badge bg-info text-dark ms-1">
                                        {{ $order->copies }}x Copy
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Ketergesaan -->
                            <td>
                                @if($order->urgency_level >= 8)
                                    <span class="badge badge-urgent-danger px-3 py-1.5 rounded-pill">Sangat Urgent ({{ $order->urgency_level }}/10)</span>
                                @elseif($order->urgency_level >= 4)
                                    <span class="badge badge-urgent-warning px-3 py-1.5 rounded-pill">Penting ({{ $order->urgency_level }}/10)</span>
                                @else
                                    <span class="badge badge-urgent-secondary px-3 py-1.5 rounded-pill">Biasa ({{ $order->urgency_level }}/10)</span>
                                @endif
                            </td>

                            <!-- Lama Pengerjaan -->
                            <td>
                                <span class="badge badge-info-blue px-3 py-1.5 rounded-pill">
                                    ⏱️ {{ $order->estimated_duration_minutes }} Mnt
                                </span>
                            </td>

                            <!-- Nilai Prioritas -->
                            <td>
                                @if($order->priority_score >= 70)
                                    <span class="badge badge-urgent-danger px-3 py-1.5 rounded-pill">Tinggi ({{ $order->priority_score }})</span>
                                @elseif($order->priority_score >= 45)
                                    <span class="badge badge-urgent-warning px-3 py-1.5 rounded-pill">Sedang ({{ $order->priority_score }})</span>
                                @else
                                    <span class="badge badge-urgent-secondary px-3 py-1.5 rounded-pill">Rendah ({{ $order->priority_score }})</span>
                                @endif
                            </td>

                            <!-- Select Update Status -->
                            <td style="min-width: 160px;">
                                <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-dark rounded-3 fw-semibold text-center">
                                        <option value="Dalam Antrean AI" {{ $order->status == 'Dalam Antrean AI' ? 'selected' : '' }}>Dalam Antrean AI</option>
                                        <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Tombol Hapus -->
                            <td>
                                <form action="{{ route('admin.deleteOrder', $order->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus pesanan {{ $order->customer_name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-2 px-2.5 py-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-secondary py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>