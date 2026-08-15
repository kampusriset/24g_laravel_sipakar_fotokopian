<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Courier New', Courier, monospace; 
        }
        .nota-box { 
            max-width: 380px; 
            margin: 30px auto; 
            background: #fff; 
            padding: 25px; 
            border: 1px dashed #bbb; 
            border-radius: 8px;
        }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .nota-box { border: none; padding: 0; margin: 0; width: 100%; max-width: 100%; box-shadow: none !important; }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi (Tidak Ikut Tercetak Saat Print) -->
    <div class="no-print text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary btn-sm fw-bold me-2">
            🖨️ Cetak Nota / Simpan PDF
        </button>
        <a href="{{ route('order.status', $order->id) }}" class="btn btn-outline-secondary btn-sm">
            ← Kembali ke Status Pesanan
        </a>
    </div>

    <!-- Tampilan Struk / Nota Resmi Kasir -->
    <div class="nota-box shadow-sm">
        <!-- Header Brand Nama Toko -->
        <div class="text-center mb-3 border-bottom pb-2">
            <h5 class="fw-bold mb-0">🖨️ PUNAZA COPY</h5>
            <small class="text-muted">Sistem Antrean Prioritas AI</small><br>
            <small class="text-muted">No. Nota: #{{ $order->id }} | {{ $order->created_at->format('d/m/Y H:i') }}</small>
        </div>

        <div class="mb-3 small">
            <div><strong>Pelanggan:</strong> {{ $order->customer_name }}</div>
            <div><strong>Metode Bayar:</strong> {{ $order->payment_method ?? 'Bayar di Kasir (Tunai/QRIS)' }}</div>
        </div>

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
            $totalTagihan = $biayaCetak + $biayaJilidTotal;
        @endphp

        <!-- Tabel Perhitungan Detail Cetak & Jilid -->
        <table class="table table-borderless table-sm small border-top border-bottom my-2 py-2">
            <tbody>
                <tr>
                    <td>Cetak ({{ $order->total_pages }} Hal x {{ $copies }} Copy)</td>
                    <td class="text-end">Rp {{ number_format($biayaCetak, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Jilid ({{ ucfirst($order->binding_type) }} x {{ $copies }})</td>
                    <td class="text-end">
                        Rp {{ number_format($biayaJilidTotal, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between font-monospace fw-bold fs-6 my-2">
            <span>TOTAL TAGIHAN:</span>
            <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
        </div>

        <!-- Footer Ucapan Terima Kasih -->
        <div class="text-center mt-4 border-top pt-3 text-muted extra-small" style="font-size: 11px;">
            <p class="mb-1">Terima kasih telah mencetak di Punaza Copy!</p>
            <p class="mb-0">Perkiraan Selesai: <strong>{{ $order->created_at->addMinutes($order->estimated_duration_minutes)->format('H:i') }} WIB</strong></p>
        </div>
    </div>

</body>
</html>