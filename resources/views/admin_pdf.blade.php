<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Antrean - Punaza Copy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pengaturan Khusus Kertas & Mode Cetak PDF */
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #212529;
            background-color: #fff;
        }

        .header-laporan {
            border-bottom: 2px solid #212529;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .table-pdf {
            width: 100%;
            border-collapse: collapse;
        }

        .table-pdf th, .table-pdf td {
            border: 1px solid #dee2e6;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .table-pdf th {
            background-color: #f8f9fa !important;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .table-pdf tr {
            page-break-inside: avoid;
        }

        .badge-status {
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
            display: inline-block;
        }

        .bg-selesai { background-color: #d1e7dd; color: #0f5132; }
        .bg-proses { background-color: #cff4fc; color: #055160; }
        .bg-antrean { background-color: #fff3cd; color: #664d03; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Navigasi (Hilang Saat Diprint/Save PDF) -->
    <div class="mb-3 no-print text-end">
        <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold me-1">
            🖨️ Cetak / Simpan PDF
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            ← Kembali ke Dashboard Admin
        </a>
    </div>

    <!-- Kop Header Laporan -->
    <div class="header-laporan text-center">
        <h4 class="fw-bold mb-1">🖨️ PUNAZA COPY</h4>
        <h6 class="text-uppercase fw-semibold text-secondary mb-1">Laporan Jadwal Prioritas Antrean & Pengerjaan</h6>
        <small class="text-muted">Tanggal Cetak: {{ date('d/m/Y - H:i') }} WIB</small>
    </div>

    <!-- Tabel Data Laporan -->
    <table class="table-pdf text-center">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="7%">Nota</th>
                <th width="16%">Nama Pemesan</th>
                <th width="14%">Detail Cetak</th>
                <th width="6%">Copy</th>
                <th width="11%">Urgensi</th>
                <th width="10%">Durasi</th>
                <th width="10%">Skor AI</th>
                <th width="12%">Metode Bayar</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td>#{{ $index + 1 }}</td>
                <td>#{{ $order->id }}</td>
                <td class="text-start fw-bold">{{ $order->customer_name }}</td>
                <td class="text-start">{{ $order->total_pages }} Hal ({{ ucfirst($order->binding_type) }})</td>
                <td>{{ $order->copies ?? 1 }}x</td>
                <td>{{ $order->urgency_level }}/10</td>
                <td>{{ $order->estimated_duration_minutes }} Mnt</td>
                <td><strong>{{ $order->priority_score }}</strong> Poin</td>
                <td>{{ $order->payment_method ?? 'Kasir' }}</td>
                <td>
                    @if($order->status == 'Selesai')
                        <span class="badge-status bg-selesai">Selesai</span>
                    @elseif($order->status == 'Diproses')
                        <span class="badge-status bg-proses">Dicetak</span>
                    @else
                        <span class="badge-status bg-antrean">Antrean AI</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-muted py-3">Belum ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3 text-end text-muted small" style="font-size: 10px;">
        <em>Dicetak otomatis oleh Sistem Antrean Prioritas AI - Punaza Copy</em>
    </div>

</body>
</html>