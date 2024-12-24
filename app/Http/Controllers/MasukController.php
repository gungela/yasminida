<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Produksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produksi = Produksi::where('status', 'masuk')->get();
            return DataTables::of($produksi)
                ->addIndexColumn()
                ->editColumn('date', function ($item) {
                    return \Carbon\Carbon::parse($item->date)->format('d/m/Y'); // Format tanggal
                })
                ->editColumn('supplier', function ($item) {
                    return $item->user->name;
                })
                ->editColumn('harga', function ($item) {
                    $total = $item->harga;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })
                ->editColumn('total', function ($item) {
                    $total = $item->jumlah * $item->harga;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })
                ->editColumn('praproduct', function ($item) {
                    return $item->praproduct ?? '-'; 
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
                            <a href="' . route('masuk.edit', $item->id) . '" class="menu-link px-3">
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
        return view('masuk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $praproducts = Produksi::select('praproduct')->where('status', 'mentah')->get();
        return view('masuk.create', [
            'produksi' => new Produksi(),
            'praproducts' => $praproducts,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'user_id' => 'required|exists:users,id',
            'praproduct' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
        ]);
        $total = $request->jumlah * $request->harga;
        Produksi::create([
            'date' => $request->date,
            'user_id' => $request->user_id,
            'praproduct' => $request->praproduct,
            'product' => $request->product,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'total' => $total,
            'status' => 'masuk',
        ]);

        return redirect()->route('masuk.index')->with('success', 'Data Produk Masuk berhasil disimpan.');
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
        $produksi = Produksi::whereId($id)->firstOrFail();
        $praproduct = Produksi::select('praproduct')->where('status', 'mentah')->get();
        return view('masuk.edit', [
            'produksi' => $produksi,
            'praproduct' => $praproduct
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produksi = Produksi::findOrFail($id);

        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'user_id' => 'required|exists:users,id',
            'praproduct' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        // Hitung total
        $total = $request->input('jumlah') * $request->input('harga');

        // Update data
        $produksi->update([
            'date' => $request->input('date'),
            'user_id' => $request->input('user_id'),
            'praproduct' => $request->input('praproduct'),
            'product' => $request->input('product'),
            'jumlah' => $request->input('jumlah'),
            'harga' => $request->input('harga'),
            'total' => $total,
            'status' => 'masuk',
        ]);

        return redirect()->route('masuk.index')->with('success', 'Data Produksi Masuk diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produksi = Produksi::findOrFail($id);
            $produksi->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'produksi Masuk Deleted!',
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
        $produksi = Produksi::where('status', 'masuk')->get();

        return view('masuk.print', compact('produksi'));
    }
}
