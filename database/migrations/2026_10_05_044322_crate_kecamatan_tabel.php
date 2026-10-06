<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kecamatan',function(Blueprint $table){
            $table->id();
            $table->string('kode_kecamatan');
            $table->string('nama_kecamatan');
            $table->string('kode_kabupaten_kota');
            $table->string('nama_kabupaten_kota');
            $table->timestamps();
        });

        DB::statement(" ALTER TABLE kecamatan ADD geom GEOMETRY(MultiPolygon, 4326) ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
