<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PetaPbbController extends Controller
{

    public function dashboard()
    {
        try {
            $stats = DB::table('data_tanah')
                ->selectRaw("
                    COUNT(*)::int                                                              AS total,
                    SUM(CASE WHEN status_pem = 'SUDAH BAYAR'              THEN 1 ELSE 0 END)::int AS sudah_bayar,
                    SUM(CASE WHEN status_pem = 'BELUM BAYAR / BELUM LUNAS' THEN 1 ELSE 0 END)::int AS belum_bayar,
                    SUM(CASE WHEN status_pem = 'PBB BAYAR 0 RUPIAH'       THEN 1 ELSE 0 END)::int AS pbb_nol,
                    SUM(CASE WHEN status_pem NOT IN ('SUDAH BAYAR','BELUM BAYAR / BELUM LUNAS','PBB BAYAR 0 RUPIAH') THEN 1 ELSE 0 END)::int AS lainnya
                ")
                ->whereNotNull('geom')
                ->first();

            return view('katalog.dashboard', compact('stats'));

        } catch (\Exception $e) {
            return view('katalog.dashboard', [
                'stats' => null,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function index()
    {
        try {

            // Ambil data GIS dari PostGIS (data_tanah)
            $data = DB::table('data_tanah')
                ->selectRaw('
                    gid,
                    idobjekpaj,
                    luas_tanah,
                    luas_bangu,
                    rt, rw,
                    ratio,
                    status_pem,
                    shape_leng,
                    shape_area,
                    ST_AsGeoJSON(geom) as geometry
                ')
                ->whereNotNull('geom')
                ->limit(500)
                ->get();

            return view('katalog.pbbp2', compact('data'));

        } catch (\Exception $e) {

            // fallback agar tidak error 500 blank
            return view('katalog.pbbp2', [
                'data' => collect([]),
                'error' => $e->getMessage()
            ]);
        }
    }
}