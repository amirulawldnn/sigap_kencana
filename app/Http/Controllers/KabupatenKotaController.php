<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    public function index()
    {
        try {
            $features = DB::table('kabupaten_kota')
                ->selectRaw("
                    kode_kabupaten_kota,
                    nama_kabupaten_kota,
                    ST_AsGeoJSON(geom) AS geometry
                ")
                ->orderBy('kode_kabupaten_kota')
                ->get();

            $geojson = [
                'type' => 'FeatureCollection',
                'features' => $features->map(function ($item) {
                    return [
                        'type' => 'Feature',
                        'geometry' => json_decode($item->geometry),
                        'properties' => [
                            'kode_kabupaten_kota' => $item->kode_kabupaten_kota,
                            'nama_kabupaten_kota' => $item->nama_kabupaten_kota,
                        ],
                    ];
                })->values(),
            ];

            return response()->json($geojson);
        } catch (\Throwable $e) {
            // Fallback membaca file data static jika database PostGIS tidak terkoneksi (misal di cloud Vercel)
            $fallbackFile = public_path('data/kabupaten_kota.json');
            if (file_exists($fallbackFile)) {
                return response()->file($fallbackFile, [
                    'Content-Type' => 'application/json'
                ]);
            }
            throw $e;
        }
    }
}
