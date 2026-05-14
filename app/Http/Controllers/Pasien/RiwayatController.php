<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = DaftarPoli::where('id_pasien', Auth::id())
            ->whereHas('periksas')
            ->with(['jadwalPeriksa.dokter', 'periksas.detailPeriksas.obat'])
            ->latest()
            ->get();

        return view('pasien.riwayat', compact('riwayat'));
    }
}
