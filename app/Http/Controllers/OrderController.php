<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\FuzzyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Form Pemesanan
    public function index()
    {
        return view('order');
    }

    // 2. Simpan Pesanan & Hitung Fuzzy (Create)
    public function store(Request $request, FuzzyService $fuzzy)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'total_pages'   => 'required|numeric|min:1',
            'binding_type'  => 'required|string',
            'urgency_level' => 'required|numeric|min:1|max:10',
        ]);

        // Kalkulasi via FuzzyService
        $calculation = $fuzzy->calculate(
            $request->total_pages,
            $request->binding_type,
            $request->urgency_level
        );

        // Simpan ke Database
        $order = Order::create([
            'user_id'                    => Auth::id(),
            'customer_name'              => $request->customer_name,
            'total_pages'                => $request->total_pages,
            'binding_type'               => $request->binding_type,
            'urgency_level'              => $request->urgency_level,
            'estimated_duration_minutes' => $calculation['duration'],
            'priority_score'             => $calculation['priority_score'],
            'status'                     => 'Dalam Antrean AI',
        ]);

        return redirect()->route('order.status', $order->id);
    }

    // 3. Tampilkan Status Pesanan Pelanggan (Read)
    public function status($id)
    {
        $order = Order::findOrFail($id);

        // Hitung akumulasi menit antrean pesanan lain yang belum selesai
        $queueMinutesBefore = Order::query()
            ->where('status', '!=', 'Selesai')
            ->where('priority_score', '>=', $order->priority_score)
            ->where('id', '!=', $order->id)
            ->where('created_at', '<=', $order->created_at)
            ->sum('estimated_duration_minutes');

        $totalWaitingMinutes = $queueMinutesBefore + $order->estimated_duration_minutes;

        return view('status', compact('order', 'totalWaitingMinutes'));
    }

    // 4. Halaman Worklist Admin (Read)
    public function admin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak! Anda bukan admin.');
        }

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

    // 7. Download PDF Pesanan Pelanggan (Poin 5 UAS)
    public function downloadPdf($id)
    {
        $order = Order::findOrFail($id);
        
        // Logika pembuatan PDF atau view struk cetak
        return view('status', compact('order'))->with('totalWaitingMinutes', $order->estimated_duration_minutes);
    }

    // 8. Export Excel Daftar Pesanan Admin (Poin 5 UAS)
    public function exportExcel()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        // Logika export excel sederhana atau download CSV
        $orders = Order::all();
        $fileName = 'Laporan_Pesanan_Admin.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Nama Pemesan', 'Total Halaman', 'Jenis Jilid', 'Urgensi', 'Durasi (Mnt)', 'Skor Prioritas', 'Status');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, array(
                    $order->id, 
                    $order->customer_name, 
                    $order->total_pages, 
                    $order->binding_type, 
                    $order->urgency_level, 
                    $order->estimated_duration_minutes, 
                    $order->priority_score, 
                    $order->status
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 9. Export PDF Laporan Pesanan Admin (Poin 5 UAS - TAMBAHAN)
    public function exportPdf()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('order.form')->with('error', 'Akses ditolak!');
        }

        $orders = Order::orderBy('priority_score', 'desc')->get();
        return view('admin_pdf', compact('orders'));
    }
}