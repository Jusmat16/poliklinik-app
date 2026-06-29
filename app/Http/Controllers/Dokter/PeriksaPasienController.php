<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        // Tampilkan SEMUA obat (termasuk stok 0) agar dokter tahu
        // ketersediaan lengkap. Opsi stok 0 di-disable di view.
        $obats = Obat::orderBy('nama_obat')->get();

        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // Bungkus dalam transaksi: kalau satu obat gagal di-decrement
        // (mis. stok habis setelah form di-load), seluruh periksa +
        // detail_periksa ikut rollback — tidak ada data setengah jadi.
        try {
            DB::transaction(function () use ($request, $obatIds) {
                // Cek stok dulu SEBELUM insert apapun. Kalau ada yang
                // habis, lempar exception agar transaction rollback.
                foreach ($obatIds as $idObat) {
                    $obat = Obat::find($idObat);

                    if (!$obat) {
                        throw new \RuntimeException("Obat dengan ID {$idObat} tidak ditemukan.");
                    }

                    if ($obat->stok < 1) {
                        throw new \RuntimeException("Stok obat {$obat->nama_obat} habis.");
                    }
                }

                // Stok aman → buat record periksa + detail + decrement.
                $periksa = Periksa::create([
                    'id_daftar_poli' => $request->id_daftar_poli,
                    'tgl_periksa' => now(),
                    'catatan' => $request->catatan,
                    'biaya_periksa' => $request->biaya_periksa + 150000,
                ]);

                foreach ($obatIds as $idObat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);

                    // Auto-decrement stok tiap kali obat diresepkan.
                    Obat::where('id', $idObat)->decrement('stok');
                }
            });
        } catch (\RuntimeException $e) {
            return back()
                ->withErrors(['obat' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('periksa-pasien.index')
            ->with('message', 'Data periksa berhasil disimpan.')
            ->with('type', 'success');
    }
}