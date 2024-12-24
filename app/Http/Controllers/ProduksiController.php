<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Produksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produksi = Produksi::where('status', 'mentah')->get();
            return DataTables::of($produksi)
                ->addIndexColumn()
                ->editColumn('date', function ($item) {
                    return \Carbon\Carbon::parse($item->date)->format('d/m/Y'); // Format tanggal
                })
                ->editColumn('harga', function ($item) {
                    $total = $item->harga ;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })
                
                ->editColumn('total', function ($item) {
                    $total = $item->jumlah * $item->harga;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })

                ->editColumn('supplier', function ($item) {
                    return $item->customer->name;
                })
                ->addColumn('actions', function ($item) {
                    return
                        '<div class="dropdown text-end">
                    <button type="button" class="btn btn-secondary btn-sm btn-active-light-primary rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-bs-toggle="dropdown">
                        Actions
                        <span class="svg-icon svg-icon-3 rotate-180 ms-3 me-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-100px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="' . route('produksi.edit', $item->id) . '" class="menu-link px-3">
                                Edit Profile
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a class="menu-link px-3 delete-confirm" data-id="' . $item->id . '" role="button">Hapus</a>
                        </div>
                    </div>
                </div>';
                })
                ->rawColumns(['actions'])
                ->make();
        }
        return view('produksi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Customer::where('status', 'supplier')->get();
        return view('produksi.create', [
            'produksi' => new Produksi(),
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'customer_id' => 'required|exists:customers,id', // Pastikan customer_id ada di tabel customers
            'praproduct' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer',
        ]);
        $total = $request->jumlah * $request->harga;
        Produksi::create([
            'date' => $request->date,
            'customer_id' => $request->customer_id, // Ambil dari input form
            'praproduct' => $request->praproduct,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'status' => 'mentah',
        ]);

        // Mengarahkan kembali ke halaman yang diinginkan dengan pesan sukses
        return redirect()->route('produksi.index')->with('success', 'Data produksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produksi $produksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produksi = Produksi::whereId($id)->firstOrFail();
        $suppliers = Customer::where('status', 'supplier')->get();
        return view('produksi.edit', [
            'produksi' => $produksi,
            'suppliers' => $suppliers,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksi $produksi)
    {
        // Validasi data input
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'praproduct' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'customer_id' => 'required|exists:customers,id', // pastikan customer id valid (supplier)
        ]);

        // Update data produksi
        $produksi->update([
            'date' => $request->input('date'),
            'praproduct' => $request->input('praproduct'),
            'jumlah' => $request->input('jumlah'),
            'harga' => $request->input('harga'),
            'total' => $request->input('jumlah') * $request->input('harga'), // Hitung total otomatis
            'customer_id' => $request->input('customer_id'),
        ]);

        // Redirect ke halaman list dengan pesan sukses
        return redirect()->route('produksi.index')->with('success', 'Data Produksi berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produksi $produksi)
    {
        try {
            $produksi->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'produksi Deleted!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function print()
    {
        $produksi = Produksi::where('status', 'mentah')->get();

        return view('produksi.print', compact('produksi'));
    }
}
