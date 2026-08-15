<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FuzzyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Form Pemesanan (Read)
    public function index()
    {
        return view('order');
    }

    // 2. Simpan Pesanan & Hitung Fuzzy (Create)
    public function store(Request $request, FuzzyService $fuzzy)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'total_pages'    => 'required|numeric|min:1',
            'copies'         => 'required|numeric|min:1',
            'binding_type'   => 'required|string',
            'urgency_level'  => 'required|numeric|min:1|max:10',
            'payment_method' => 'required|string',
        ]);

        // Total lembar keseluruhan yang dicetak (Total Halaman x Jumlah Copy)
        $effectiveTotalPages = $request->total_pages * $request->copies;

        // Kalkulasi via FuzzyService menggunakan total lembar cetak
        $calculation = $fuzzy->calculate(
            $effectiveTotalPages,
            $request->binding_type,
            $request->urgency_level
        );

        // Simpan ke Database
        $order = Order::create([
            'user_id'                    => Auth::id(),
            'customer_name'              => $request->customer_name,
            'total_pages'                => $request->total_pages,
            'copies'                     => $request->copies,
            'binding_type'               => $request->binding_type,
            'urgency_level'              => $request->urgency_level,
            'payment_method'             => $request->payment_method,
            'estimated_duration_minutes' => $calculation['duration'],
            'priority_score'             => $calculation['priority_score'],
            'status'                     => 'Dalam Antrean AI',
        ]);

        return redirect()->route('order.status', $order->id);
    }

    // 3. Tampilkan Status Pesanan Pelanggan (Read - Fuzzy Priority + FIFO)
    public function status($id)
    {
        $order = Order::findOrFail($id);
        $queueData = $this->calculateQueueTime($order);

        return view('status', [
            'order'               => $order,
            'totalWaitingMinutes' => $queueData['totalWaitingMinutes'],
            'estimatedFinishTime' => $queueData['estimatedFinishTime'],
            'queueMinutesBefore'  => $queueData['queueMinutesBefore'],
        ]);
    }

    // 4. Halaman Worklist Admin (Read)
    public function admin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

        // Urutkan berdasarkan Skor Prioritas AI Terbesar, lalu Waktu Order (FIFO)
        $orders = Order::orderBy('priority_score', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin', compact('orders'));
    }

    // 5. Update Status Pesanan oleh Admin (Update)
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // 6. Hapus Pesanan oleh Admin (Delete)
    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus!');
    }

    // 7. Download PDF / Cetak Nota Pesanan Pelanggan
    public function downloadPdf($id)
    {
        $order = Order::findOrFail($id);
        $queueData = $this->calculateQueueTime($order);

        return view('status', [
            'order'               => $order,
            'totalWaitingMinutes' => $queueData['totalWaitingMinutes'],
            'estimatedFinishTime' => $queueData['estimatedFinishTime'],
            'queueMinutesBefore'  => $queueData['queueMinutesBefore'],
        ]);
    }

    // 8. Export Excel Daftar Pesanan Admin (CSV Output)
    public function exportExcel()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        $orders = Order::orderBy('priority_score', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        $fileName = 'Laporan_Pesanan_Admin_PunazaCopy.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nama Pemesan', 'Total Halaman', 'Jumlah Copy', 'Jenis Jilid', 'Urgensi', 'Metode Bayar', 'Durasi (Mnt)', 'Skor Prioritas', 'Status'];

        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id, 
                    $order->customer_name, 
                    $order->total_pages, 
                    $order->copies ?? 1,
                    $order->binding_type, 
                    $order->urgency_level, 
                    $order->payment_method ?? 'Bayar di Kasir',
                    $order->estimated_duration_minutes, 
                    $order->priority_score, 
                    $order->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 9. Export PDF Laporan Pesanan Admin
    public function exportPdf()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        $orders = Order::orderBy('priority_score', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin_pdf', compact('orders'));
    }

    /**
     * Helper privat untuk menghitung total durasi antrean dan estimasi jam selesai.
     */
    private function calculateQueueTime(Order $order): array
    {
        // Hitung akumulasi durasi pesanan lain yang belum selesai di depan pesanan ini
        $queueMinutesBefore = Order::query()
            ->where('status', '!=', 'Selesai')
            ->where('id', '!=', $order->id)
            ->where(function ($query) use ($order) {
                $query->where('priority_score', '>', $order->priority_score)
                      ->orWhere(function ($q) use ($order) {
                          $q->where('priority_score', '=', $order->priority_score)
                            ->where('created_at', '<', $order->created_at);
                      });
            })
            ->sum('estimated_duration_minutes');

        $totalWaitingMinutes = $queueMinutesBefore + $order->estimated_duration_minutes;
        $estimatedFinishTime = $order->created_at->addMinutes($totalWaitingMinutes);

        return [
            'queueMinutesBefore'  => $queueMinutesBefore,
            'totalWaitingMinutes' => $totalWaitingMinutes,
            'estimatedFinishTime' => $estimatedFinishTime,
        ];
    }
}