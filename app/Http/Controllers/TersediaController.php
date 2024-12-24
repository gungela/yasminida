<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Produksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TersediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        //     $data = Produksi::selectRaw("
        //     product AS nama_barang,
        //     'Produk' AS jenis,
        //     (
        //         NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
        //         SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
        //         SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
        //     ) AS total_qty,
        //     MAX(harga) AS harga,
        //     (
        //         (
        //             NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
        //             SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
        //             SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
        //         ) * MAX(harga)
        //     ) AS total_harga
        // ")
        $data = Produksi::selectRaw("
            product AS nama_barang,
            'Produk' AS jenis,
            (
                NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
                SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
                SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
            ) AS total_qty,
            MAX(harga) AS harga,
            (
                (
                    NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
                    SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
                    SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
                ) * MAX(harga)
            ) AS total_harga,
            MAX(CASE WHEN status IN ('masuk', 'keluar', 'rusak') THEN date ELSE NULL END) AS tanggal
        ")
        ->whereNotNull('product')
        ->groupBy('nama_barang')
        ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function ($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y'); // Format tanggal
                })
                ->editColumn('jenis', function ($item) {
                    return $item->jenis;
                })
                ->editColumn('nama_barang', function ($item) {
                    return $item->nama_barang;
                })
                ->editColumn('total_qty', function ($item) {
                    return $item->total_qty;
                })
                ->editColumn('harga', function ($item) {
                    return 'Rp ' . number_format($item->harga, 0, ',', '.');
                })
                ->editColumn('total_harga', function ($item) {
                    return 'Rp ' . number_format($item->total_harga, 0, ',', '.');
                })
                ->make(true);
        }

        return view('tersedia.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function print()
    {
        $produksi = Produksi::selectRaw("
        product AS nama_barang,
        'Produk' AS jenis,
        (
            NULLIF(SUM(CASE WHEN status = 'masuk' THEN jumlah ELSE 0 END), 0) -
            SUM(CASE WHEN status = 'keluar' THEN jumlah ELSE 0 END) -
            SUM(CASE WHEN status = 'rusak' THEN jumlah ELSE 0 END)
        ) AS total_qty
    ")
    ->whereNotNull('product')
    ->groupBy('nama_barang')
    ->get();


        return view('tersedia.print', compact('produksi'));
    }
}
