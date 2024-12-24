<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Produksi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;

class KeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produksi = Produksi::where('status', 'keluar')->get();
            return DataTables::of($produksi)
                ->addIndexColumn()
                ->editColumn('date', function ($item) {
                    return \Carbon\Carbon::parse($item->date)->format('d/m/Y'); // Format tanggal
                })
                ->editColumn('harga', function ($item) {
                    $total = $item->harga;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })

                ->editColumn('total', function ($item) {
                    $total = $item->jumlah * $item->harga;
                    return 'Rp ' . number_format($total, 0, ',', '.'); // Format total as currency
                })
                ->editColumn('supplier', function ($item) {
                    return $item->customer->name;
                })
                ->editColumn('pelanggan', function ($item) {
                    return $item->user->name;
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
                            <a href="' . route('keluar.edit', $item->id) . '" class="menu-link px-3">
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
        return view('keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Produksi::select('product')->where('status', 'masuk')->get();
        $pelanggans = Customer::where('status', 'pelanggan')->get();
        return view('keluar.create', [
            'products' => $products,
            'pelanggans' => $pelanggans
        ]);
    }

    // Method untuk mengambil jumlah produk
    public function getJumlahProduct($product)
    {
        // Cari jumlah produk berdasarkan nama produk
        $produk = Produksi::where('product', $product)->first();

        if ($produk) {
            return response()->json([
                'success' => true,
                'praproduct' => $produk->praproduct,
                'jumlah' => $produk->jumlah,
                'harga' => $produk->harga,
                'total' => $produk->total,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|integer|min:0',
            'jumlah_beli' => 'required|integer|min:1',
        ]);


        $produksi = Produksi::where('product', $request->product)->first();

        if ($produksi) {
            $newJumlah = $produksi->jumlah - $request->jumlah_beli;

            if ($newJumlah < 0) {
                return redirect()->back()->withErrors(['jumlah_beli' => 'Jumlah beli tidak boleh melebihi stok yang tersedia.'])->withInput();
            }


            $total = $newJumlah * $produksi->harga;
            Produksi::create([
                'date' => $request->date,
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
                'praproduct' => $request->praproduct,
                'product' => $request->product,
                'jumlah' => $request->jumlah_beli,
                'harga' => $request->harga,
                'total' => $total,
                'status' => 'keluar'
            ]);
        }

        return redirect()->route('keluar.index')->with('success', 'Data Produk Keluar berhasil disimpan!');
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
        $products = Produksi::select('product')->where('status', 'masuk')->get();
        $pelanggans = Customer::where('status', 'pelanggan')->get();
        return view('keluar.edit', [
            'produksi' => $produksi,
            'products' => $products,
            'pelanggans' => $pelanggans
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|integer|min:0',
            'jumlah_beli' => 'required|integer|min:1',
        ]);

        // Cari produksi berdasarkan ID yang ingin diperbarui
        $produksi = Produksi::findOrFail($id);

        // Hitung stok baru setelah update
        $newJumlah = $produksi->jumlah - $request->jumlah_beli;

        // Pastikan jumlah beli tidak melebihi stok yang tersedia
        if ($newJumlah < 0) {
            return redirect()->back()->withErrors(['jumlah_beli' => 'Jumlah beli tidak boleh melebihi stok yang tersedia.'])->withInput();
        }

        // Hitung total harga berdasarkan stok baru
        $total = $newJumlah * $produksi->harga;

        // Update data produksi
        $produksi->update([
            'date' => $request->date,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'praproduct' => $request->praproduct,
            'product' => $request->product,
            'jumlah' => $request->jumlah_beli,
            'harga' => $request->harga,
            'total' => $total,
            'status' => 'keluar'
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('keluar.index')->with('success', 'Data Produk Keluar berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produksi = Produksi::findOrFail($id);

            // Hapus data produksi
            $produksi->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'produksi Keluar Deleted!',
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
        $produksi = Produksi::where('status', 'keluar')->get();

        return view('keluar.print', compact('produksi'));
    }
}
