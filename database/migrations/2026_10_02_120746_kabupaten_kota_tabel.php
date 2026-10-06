<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupaten_kota', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kabupaten_kota');
            $table->string('kode_kabupaten_kota', 10);
            $table->string('kode_provinsi', 10);
            $table->string('nama_provinsi');
            $table->timestamps();
        });

        DB::statement("
            AlTER TABLE kabupaten_kota
            ADD COLUMN geom geometry(MultiPolygon, 4326)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupaten_kota');
    }
};
