<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index() {
        $masuk = Produksi::where('status', 'masuk')->count();
        $keluar = Produksi::where('status', 'keluar')->count();
        $rusak = Produksi::where('status', 'rusak')->count();
        $tersedia = max($masuk - $keluar - $rusak, 0);
        return view('dashboard',compact('masuk','keluar','rusak','tersedia'));
    }
}
