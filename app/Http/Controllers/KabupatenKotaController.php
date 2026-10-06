<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KabupatenKotaController extends Controller
{
    public function index()
    {
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
    }
}
