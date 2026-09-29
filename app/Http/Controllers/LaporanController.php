<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function checklist(Request $request)
    {
        $query = Maintenance::with(['perangkat', 'user'])
            ->whereNotNull('checklist');

        $this->applyFilters($query, $request);

        $maintenances = $query->latest()->paginate(10)->withQueryString();
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();

        return view('laporan.checklist', compact('maintenances', 'perangkatList'));
    }

    public function maintenance(Request $request)
    {
        $query = Maintenance::with(['perangkat', 'user']);
        $this->applyFilters($query, $request);

        $maintenances  = $query->latest()->paginate(15)->withQueryString();
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();

        $totalSelesai  = (clone $query->getQuery())->where('status', 'Selesai')->count();

        return view('laporan.maintenance', compact('maintenances', 'perangkatList', 'totalSelesai'));
    }

    public function eviden(Request $request)
    {
        $query = Maintenance::with(['perangkat', 'user'])
            ->whereNotNull('eviden');

        $this->applyFilters($query, $request);

        $maintenances  = $query->latest()->paginate(12)->withQueryString();
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();

        return view('laporan.eviden', compact('maintenances', 'perangkatList'));
    }

    public function cetak(Request $request, string $type)
    {
        $query = Maintenance::with(['perangkat', 'user']);
        $this->applyFilters($query, $request);
        $maintenances  = $query->latest()->get();
        $perangkatList = Perangkat::all();
        $periode       = $this->getPeriodeLabel($request);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pdf', compact('maintenances', 'perangkatList', 'type', 'periode'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("laporan_{$type}_{$periode}.pdf");
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('perangkat_id')) {
            $query->where('perangkat_id', $request->perangkat_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', Carbon::parse($request->bulan)->month)
                ->whereYear('tanggal', Carbon::parse($request->bulan)->year);
        }
    }

    private function getPeriodeLabel(Request $request): string
    {
        if ($request->filled('bulan')) {
            return Carbon::parse($request->bulan)->format('Y_m');
        }
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            return $request->tanggal_dari . '_sd_' . $request->tanggal_sampai;
        }
        return Carbon::now()->format('Y_m_d');
    }
}
