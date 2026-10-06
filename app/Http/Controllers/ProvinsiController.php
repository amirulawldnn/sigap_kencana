<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\JsonResponse;

class ProvinsiController extends Controller
{
    public function index(): JsonResponse
    {
    $provinsi = Provinsi::query()
        ->select(
            'id',
            'nama_provinsi',
            'kode_provinsi'
        )
        ->selectRaw('ST_AsGeoJSON(geom) AS geometry')
        ->first();

    return response()->json([
        'type' => 'Feature',
        'properties' => [
            'id' => $provinsi->id,
            'nama_provinsi' => $provinsi->nama_provinsi,
            'kode_provinsi' => $provinsi->kode_provinsi,
        ],
        'geometry' => json_decode($provinsi->geometry),
    ]);
}
}