<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $table = 'perangkat';

    protected $fillable = [
        'kode_perangkat',
        'nama_perangkat',
        'jenis_perangkat',
        'merk',
        'model',
        'no_seri',
        'lokasi',
        'ruangan',
        'tanggal_install',
        'kondisi',
        'status',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'tanggal_install' => 'date',
    ];

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function maintenanceTerakhir()
    {
        return $this->hasOne(Maintenance::class)->latestOfMany();
    }

    public function scopeKondisiBaik($query)
    {
        return $query->where('kondisi', 'Baik');
    }

    public function scopeKondisiRusak($query)
    {
        return $query->whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat']);
    }

    public function getBadgeKondisiAttribute(): string
    {
        return match ($this->kondisi) {
            'Baik'        => 'badge-success',
            'Rusak Ringan' => 'badge-warning',
            'Rusak Berat'  => 'badge-danger',
            default       => 'badge-secondary',
        };
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'Aktif'          => 'badge-success',
            'Tidak Aktif'    => 'badge-secondary',
            'Dalam Perbaikan' => 'badge-warning',
            default          => 'badge-secondary',
        };
    }
}