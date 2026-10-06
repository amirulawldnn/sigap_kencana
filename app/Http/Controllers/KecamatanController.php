<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    /**
     * Ambil data GeoJSON kecamatan berdasarkan kode kabupaten/kota.
     */
    public function byKabupaten(string $kode)
    {
        $features = DB::table('kecamatan')
            ->where('kode_kabupaten_kota', $kode)
            ->selectRaw("
                kode_kecamatan,
                nama_kecamatan,
                kode_kabupaten_kota,
                nama_kabupaten_kota,
                ST_AsGeoJSON(geom) AS geometry
            ")
            ->orderBy('nama_kecamatan')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features->map(function ($item) {
                return [
                    'type' => 'Feature',
                    'geometry' => json_decode($item->geometry),
                    'properties' => [
                        'kode_kecamatan'      => $item->kode_kecamatan,
                        'nama_kecamatan'      => $item->nama_kecamatan,
                        'kode_kabupaten_kota' => $item->kode_kabupaten_kota,
                        'nama_kabupaten_kota' => $item->nama_kabupaten_kota,
                    ],
                ];
            })->values(),
        ];

        return response()->json($geojson);
    }
}
