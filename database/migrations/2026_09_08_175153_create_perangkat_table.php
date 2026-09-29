<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perangkat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perangkat')->unique();
            $table->string('nama_perangkat');
            $table->string('jenis_perangkat'); // Server, Router, Switch, OLT, dll
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->string('no_seri')->nullable();
            $table->string('lokasi');
            $table->string('ruangan')->nullable();
            $table->date('tanggal_install')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Dalam Perbaikan'])->default('Aktif');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat');
    }
};
