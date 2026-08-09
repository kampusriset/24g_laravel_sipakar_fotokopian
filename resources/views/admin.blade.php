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
            <a class="navbar-brand fw-bold text-warning" href="{{ route('admin.dashboard') }}">⚡ Admin Panel Fotokopi</a>
            
            <div class="d-flex align-items-center gap-3 text-white">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-warning btn-sm">🏠 Mode Pelanggan</a>
                <span class="small">Halo, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        
        <!-- CARD RINGKASAN STATISTIK DASHBOARD -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-primary border-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted fw-bold text-uppercase small">Total Pesanan</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ count($orders) }}</h3>
                        </div>
                        <div class="fs-1">📦</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-warning border-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted fw-bold text-uppercase small">Perlu Diproses</span>
                            <h3 class="fw-bold mb-0 text-warning">
                                {{ $orders->whereIn('status', ['Dalam Antrean AI', 'Dalam Antrean'])->count() }}
                            </h3>
                        </div>
                        <div class="fs-1">⏳</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-success border-4 p-3 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted fw-bold text-uppercase small">Pesanan Selesai</span>
                            <h3 class="fw-bold mb-0 text-success">
                                {{ $orders->where('status', 'Selesai')->count() }}
                            </h3>
                        </div>
                        <div class="fs-1">✅</div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mb-4 fw-bold">Jadwal Prioritas Pengerjaan</h2>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Area Tombol Aksi (Tambah, Export Excel & Export PDF) -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('order.form') }}" class="btn btn-primary fw-semibold">+ Tambah Pesanan Baru</a>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.exportExcel') }}" class="btn btn-success fw-semibold">📥 Export Excel</a>
                <a href="{{ route('admin.exportPdf') }}" target="_blank" class="btn btn-danger fw-semibold">📄 Export PDF</a>
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
                    @forelse($orders as $index => $order)
                    <tr>
                        <td><span class="badge bg-danger fs-6">#{{ $index + 1 }}</span></td>
                        <td class="text-start ps-3 fw-semibold">{{ $order->customer_name }}</td>
                        <td class="text-start ps-3">{{ $order->total_pages }} hlm ({{ $order->binding_type }})</td>
                        
                        <td>
                            @if($order->urgency_level >= 6)
                                <span class="badge bg-danger">Sangat Urgent</span>
                            @elseif($order->urgency_level >= 3)
                                <span class="badge bg-warning text-dark">Penting</span>
                            @else
                                <span class="badge bg-secondary">Biasa</span>
                            @endif
                        </td>

                        <td>
                            @if($order->estimated_duration_minutes <= 15)
                                <span class="badge bg-info text-dark">Cepat ({{ $order->estimated_duration_minutes }} Mnt)</span>
                            @elseif($order->estimated_duration_minutes <= 45)
                                <span class="badge bg-primary">Sedang ({{ $order->estimated_duration_minutes }} Mnt)</span>
                            @else
                                <span class="badge bg-dark">Lama ({{ $order->estimated_duration_minutes }} Mnt)</span>
                            @endif
                        </td>

                        <td>
                            @if($order->priority_score >= 60)
                                <span class="badge bg-secondary fs-6">Tinggi ({{ $order->priority_score }})</span>
                            @elseif($order->priority_score >= 30)
                                <span class="badge bg-secondary fs-6">Sedang ({{ $order->priority_score }})</span>
                            @else
                                <span class="badge bg-secondary fs-6">Rendah ({{ $order->priority_score }})</span>
                            @endif
                        </td>

                        <td style="width: 160px;">
                            <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm fw-semibold">
                                    <option value="Dalam Antrean AI" {{ $order->status == 'Dalam Antrean AI' ? 'selected' : '' }}>Dalam Antrean AI</option>
                                    <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>

                        <td>
                            <form action="{{ route('admin.deleteOrder', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan {{ $order->customer_name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-muted py-4">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>