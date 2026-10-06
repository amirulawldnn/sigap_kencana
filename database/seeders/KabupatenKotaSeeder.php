<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenKotaSeeder extends Seeder
{
    public function run(): void
    {
        $file = base_path(
            'gis/source/jawa-tengah-kabkota.geojson'
        );

        $data = json_decode(
            file_get_contents($file),
            true
        );

        foreach ($data['features'] as $feature) {

            $properties = $feature['properties'];
            $geometry = json_encode($feature['geometry']);

            DB::table('kabupaten_kota')->insert([
                'kode_kabupaten_kota' => $properties['kode_kabkota'],
                'nama_kabupaten_kota' => $properties['nama_kabkota'],
                'kode_provinsi' => $properties['kode_provinsi'],
                'nama_provinsi' => $properties['nama_provinsi'],

                'geom' => DB::raw(
                    "ST_SetSRID(
                        ST_GeomFromGeoJSON(
                            " . DB::getPdo()->quote($geometry) . "
                        ),
                        4326
                    )"
                ),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info(
            '34 Kabupaten/Kota berhasil dimasukkan.'
        );
    }
}