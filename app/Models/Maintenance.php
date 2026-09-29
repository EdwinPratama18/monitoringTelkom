<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';

    protected $fillable = [
        'user_id',
        'perangkat_id',
        'tanggal',
        'periode',
        'status',
        'checklist',
        'eviden',
        'keterangan',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'checklist' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class);
    }

    public function getBadgeStatusAttribute(): string
    {
        return match ($this->status) {
            'Dijadwalkan'  => 'badge-info',
            'Dalam Proses' => 'badge-warning',
            'Selesai'      => 'badge-success',
            'Ditunda'      => 'badge-danger',
            default        => 'badge-secondary',
        };
    }

    public function getChecklistSelesaiAttribute(): int
    {
        if (!$this->checklist) return 0;
        return collect($this->checklist)->where('checked', true)->count();
    }

    public function getChecklistTotalAttribute(): int
    {
        if (!$this->checklist) return 0;
        return count($this->checklist);
    }
}