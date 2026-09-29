<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('teknisi')->after('email'); // admin | teknisi
            $table->string('nip')->nullable()->after('role');
            $table->string('jabatan')->nullable()->after('nip');
            $table->string('no_telp')->nullable()->after('jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nip', 'jabatan', 'no_telp']);
        });
    }
};
