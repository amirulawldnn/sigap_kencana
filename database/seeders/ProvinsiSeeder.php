<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $file = base_path('gis/source/jawatengah.geojson');

    $geojson = json_decode(
        file_get_contents($file),
        true
    );

    $feature = $geojson['features'][0];

    $geometry = json_encode($feature['geometry']);

    DB::table('provinsi')->insert([
        'nama_provinsi' => $feature['properties']['nama_provinsi'],
        'kode_provinsi' => $feature['properties']['kode_provinsi'],
        'geom' => DB::raw(
            "ST_SetSRID(
                ST_GeomFromGeoJSON(" . DB::getPdo()->quote($geometry) . "),
                4326
            )"
        ),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
}
