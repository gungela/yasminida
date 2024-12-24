<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CetakController extends Controller
{
    public function index()
    {
        return view('cetak');
    }
    public function cetakPDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string'
        ]);

        $status = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($status === 'tersedia') {
            $subquery = Produksi::selectRaw("
                        MAX(praproduct) AS praproduct,
                        product,
                        (
                            NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
                            SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
                            SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
                        ) AS jumlah,
                        MAX(harga) AS harga,
                        (
                            (
                                NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
                                SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
                                SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
                            ) * MAX(harga)
                        ) AS total,
                        MAX(CASE WHEN status IN ('masuk', 'keluar', 'rusak') THEN date ELSE NULL END) AS tanggal
                    ")
                    ->whereNotNull('product')
                    ->groupBy('product');

                $produksis = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
                ->mergeBindings($subquery->getQuery()) // Untuk menjaga binding query builder
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get();
        } else {
            $produksis = Produksi::whereBetween('date', [$start_date, $end_date])
                ->where('status', $status)
                ->get();
        }

        Log::info('Data: ' . $produksis);

        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'produksis' => $produksis
        ];

        $pdf = null;

        if($status === 'tersedia') {
            $pdf = PDF::loadView('laporan-tersedia', $data);
        } else {
            $pdf = PDF::loadView('laporan', $data);
        }

        return $pdf->download('laporan.pdf');
    }

}
