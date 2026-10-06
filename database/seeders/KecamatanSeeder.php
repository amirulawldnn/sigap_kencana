<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('gis/source/jateng-kecamatan.geojson');

        if (!file_exists($file)) {
            $this->command->error("File {$file} tidak ditemukan!");
            return;
        }

        $this->command->info('Membaca file GeoJSON kecamatan...');
        $geojson = json_decode(file_get_contents($file), true);

        if (!isset($geojson['features'])) {
            $this->command->error("Format GeoJSON tidak valid!");
            return;
        }

        // Hapus data lama agar tidak duplikat saat seeder diulang
        DB::table('kecamatan')->truncate();

        $total = count($geojson['features']);
        $this->command->info("Memasukkan {$total} data kecamatan ke database...");

        foreach ($geojson['features'] as $feature) {
            $properties = $feature['properties'];
            $geometry = json_encode($feature['geometry']);

            // Format kode kabupaten (misal: "3304" -> "33.04")
            $parentKode = $properties['parent_kode'] ?? '';
            if (strlen($parentKode) === 4 && !str_contains($parentKode, '.')) {
                $kodeKabupaten = substr($parentKode, 0, 2) . '.' . substr($parentKode, 2, 2);
            } else {
                $kodeKabupaten = $parentKode;
            }

            DB::table('kecamatan')->insert([
                'kode_kecamatan'      => $properties['kode_wilayah'] ?? $properties['kode_kecamatan'],
                'nama_kecamatan'      => $properties['nama_singkat'] ?? str_replace('Kecamatan ', '', $properties['nama_wilayah']),
                'kode_kabupaten_kota' => $kodeKabupaten,
                'nama_kabupaten_kota' => $properties['kab_kota'] ?? null,
                'geom'                => DB::raw("
                    ST_SetSRID(
                        ST_Multi(
                            ST_GeomFromGeoJSON(" . DB::getPdo()->quote($geometry) . ")
                        ),
                        4326
                    )
                "),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        $this->command->info("Selesai! {$total} data kecamatan berhasil disimpan ke database.");
    }
}
