<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Perangkat;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPerangkat    = Perangkat::count();
        $perangkatBaik     = Perangkat::where('kondisi', 'Baik')->count();
        $perangkatRusak    = Perangkat::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count();
        $totalMaintenance  = Maintenance::count();
        $maintenanceSelesai = Maintenance::where('status', 'Selesai')->count();
        $maintenancePending = Maintenance::whereIn('status', ['Dijadwalkan', 'Dalam Proses'])->count();
        $totalTeknisi      = User::where('role', 'teknisi')->count();

        // Grafik maintenance per bulan (12 bulan terakhir)
        $bulanLabels = [];
        $bulanData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M Y');
            $bulanData[]   = Maintenance::whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->count();
        }

        // Grafik kondisi perangkat
        $kondisiLabels = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
        $kondisiData   = [
            Perangkat::where('kondisi', 'Baik')->count(),
            Perangkat::where('kondisi', 'Rusak Ringan')->count(),
            Perangkat::where('kondisi', 'Rusak Berat')->count(),
        ];

        // Grafik jenis perangkat
        $jenisData = Perangkat::selectRaw('jenis_perangkat, COUNT(*) as total')
            ->groupBy('jenis_perangkat')
            ->pluck('total', 'jenis_perangkat');

        // Maintenance terbaru
        $maintenanceTerbaru = Maintenance::with(['perangkat', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Perangkat dengan kondisi rusak
        $perangkatRusakList = Perangkat::kondisiRusak()->take(5)->get();

        // Data for Quick Modal Input Maintenance on Dashboard
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();
        $checklistTemplate = MaintenanceController::CHECKLIST_TEMPLATE;

        return view('dashboard', compact(
            'totalPerangkat',
            'perangkatBaik',
            'perangkatRusak',
            'totalMaintenance',
            'maintenanceSelesai',
            'maintenancePending',
            'totalTeknisi',
            'bulanLabels',
            'bulanData',
            'kondisiLabels',
            'kondisiData',
            'jenisData',
            'maintenanceTerbaru',
            'perangkatRusakList',
            'perangkatList',
            'checklistTemplate'
        ));
    }
}