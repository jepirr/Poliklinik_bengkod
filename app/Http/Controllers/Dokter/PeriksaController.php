<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();

        $daftarPolis = DaftarPoli::whereHas('jadwalPeriksa', function ($q) use ($dokter) {
            $q->where('id_dokter', $dokter->id);
        })
        ->with(['pasien', 'jadwalPeriksa', 'periksas'])
        ->latest()
        ->get();

        return view('dokter.periksa.index', compact('daftarPolis'));
    }

    public function create($id)
    {
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])->findOrFail($id);
        $obats      = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa.create', compact('daftarPoli', 'obats'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'catatan'       => 'nullable|string',
            'obat'          => 'nullable|array',
            'obat.*'        => 'exists:obat,id',
            'biaya_periksa' => 'required|integer|min:0',
        ]);

        $daftarPoli = DaftarPoli::findOrFail($id);

        if ($daftarPoli->periksas()->exists()) {
            return redirect()->route('dokter.periksa.index')
                ->with('error', 'Pasien ini sudah diperiksa.');
        }

        $periksa = Periksa::create([
            'id_daftar_poli' => $daftarPoli->id,
            'tgl_periksa'    => now(),
            'catatan'        => $request->catatan,
            'biaya_periksa'  => $request->biaya_periksa,
        ]);

        if ($request->filled('obat')) {
            foreach ($request->obat as $idObat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat'    => $idObat,
                ]);
            }
        }

        return redirect()->route('dokter.periksa.index')
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
