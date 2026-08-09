<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Utama -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500">
                <div class="md:flex md:items-center md:justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            Papan Antrean & Status Pesanan 🖨️
                        </h3>
                        <p class="text-gray-600 mt-1">
                            Cek status pengerjaan dokumenmu secara real-time di bawah ini.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('order.form') }}" 
                           style="background-color: #f59e0b !important; color: #ffffff !important; display: inline-flex; align-items: center; padding: 12px 24px; font-weight: bold; border-radius: 8px; text-decoration: none;">
                            🖨️ + Buat Pesanan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- TABEL STATUS PELANGGAN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold mb-4 text-gray-800">
                    📋 Cek Status Pesanan
                </h3>

                <!-- FORM PENCARIAN NAMA -->
                <form action="{{ url('/dashboard') }}" method="GET" class="mb-6 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Ketik nama kamu di sini (contoh: yaya)..." 
                           class="w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-md shadow-sm text-sm">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold px-5 py-2 rounded-md text-sm transition">
                        🔍 Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ url('/dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded-md text-sm flex items-center">
                            Reset
                        </a>
                    @endif
                </form>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-4 py-3">Nama Pemesan</th>
                                <th class="px-4 py-3">Detail Pesanan</th>
                                <th class="px-4 py-3">Urgensi</th>
                                <th class="px-4 py-3">Lama Pengerjaan</th>
                                <th class="px-4 py-3">Status Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Tarik semua pesanan urut terbaru
                                $allOrders = \App\Models\Order::with('user')->latest()->get();

                                // Filter pencarian aman tanpa dependensi nama kolom SQL
                                if (request('search')) {
                                    $searchKey = strtolower(request('search'));
                                    $orders = $allOrders->filter(function($item) use ($searchKey) {
                                        $strData = strtolower(json_encode($item->toArray()));
                                        $userName = strtolower($item->user->name ?? '');
                                        return str_contains($strData, $searchKey) || str_contains($userName, $searchKey);
                                    });
                                } else {
                                    $orders = $allOrders;
                                }
                            @endphp

                            @forelse($orders as $order)
                                @php
                                    $a = $order->toArray();

                                    // 1. Nama Pemesan
                                    $nama = $order->user->name ?? $a['nama_pemesan'] ?? $a['nama'] ?? 'Pelanggan';

                                    // 2. Detail Pesanan
                                    $detail = '-';
                                    if (!empty($a['detail_cetak'])) {
                                        $detail = $a['detail_cetak'];
                                    } elseif (!empty($a['jumlah_halaman'])) {
                                        $jilid = $a['jenis_jilid'] ?? $a['jilid'] ?? 'tanpa jilid';
                                        $detail = $a['jumlah_halaman'] . ' Halaman (' . $jilid . ')';
                                    } elseif (!empty($a['detail_pesanan'])) {
                                        $detail = $a['detail_pesanan'];
                                    }

                                    // 3. Urgensi
                                    $urgensi = $a['tingkat_ketergesaan'] ?? $a['urgensi'] ?? 'Biasa';

                                    // 4. Lama Pengerjaan
                                    $lama = $a['lama_pengerjaan'] ?? $a['estimasi_waktu'] ?? '-';
                                    if (is_numeric($lama)) {
                                        $lama = $lama . ' Menit';
                                    }

                                    // 5. Status
                                    $statusRaw = strtolower($a['status'] ?? '');
                                @endphp

                                <tr class="border-b bg-white hover:bg-gray-50">
                                    <!-- Nama Pemesan -->
                                    <td class="px-4 py-3 font-bold text-gray-900">
                                        👤 {{ $nama }}
                                    </td>

                                    <!-- Detail Pesanan -->
                                    <td class="px-4 py-3 font-medium text-gray-800">
                                        {{ $detail }}
                                    </td>

                                    <!-- Urgensi -->
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $urgensi }}
                                        </span>
                                    </td>

                                    <!-- Lama Pengerjaan -->
                                    <td class="px-4 py-3 font-medium text-gray-700">
                                        ⏱️ {{ $lama }}
                                    </td>

                                    <!-- Status Pesanan -->
                                    <td class="px-4 py-3">
                                        @if($statusRaw === 'selesai')
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                ✅ Selesai (Bisa Diambil)
                                            </span>
                                        @elseif($statusRaw === 'diproses' || str_contains($statusRaw, 'proses'))
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">
                                                ⚙️ Sedang Dikerjakan
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                ⏳ Dalam Antrean AI
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                        Data pesanan tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>