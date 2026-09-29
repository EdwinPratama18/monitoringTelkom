<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('perangkat_id')->constrained('perangkat')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('periode', ['Harian', 'Mingguan', 'Bulanan', 'Tahunan'])->default('Bulanan');
            $table->enum('status', ['Dijadwalkan', 'Dalam Proses', 'Selesai', 'Ditunda'])->default('Dijadwalkan');
            $table->json('checklist')->nullable(); // [{item: "...", checked: true/false, catatan: "..."}]
            $table->string('eviden')->nullable(); // path foto eviden
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
