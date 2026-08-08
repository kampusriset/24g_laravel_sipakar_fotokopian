<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Cetak Fotokopi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white font-weight-bold">Form Pemesanan & Analisis AI</div>
            <div class="card-body">
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Pemesan</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah Halaman</label>
                        <input type="number" name="total_pages" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Jilid</label>
                        <select name="binding_type" class="form-select">
                            <option value="tanpa_jilid">Tanpa Jilid</option>
                            <option value="staples">Staples</option>
                            <option value="spiral">Spiral</option>
                            <option value="hardcover">Hardcover</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tingkat Urgensi (1: Santai - 10: Urgent Sangat)</label>
                        <input type="number" name="urgency_level" min="1" max="10" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Proses dengan AI</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>