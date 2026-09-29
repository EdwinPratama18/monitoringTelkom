<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    // Template checklist default untuk infrastruktur telekomunikasi
    const CHECKLIST_TEMPLATE = [
        ['item' => 'Pemeriksaan power supply dan sumber daya listrik', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan koneksi kabel dan konektor', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan suhu dan ventilasi perangkat', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan lampu indikator status', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan kebersihan perangkat dan area sekitar', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan firmware/software versi terbaru', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pengujian konektivitas jaringan', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan log error dan alarm sistem', 'checked' => false, 'catatan' => ''],
        ['item' => 'Pemeriksaan backup konfigurasi', 'checked' => false, 'catatan' => ''],
        ['item' => 'Dokumentasi kondisi perangkat', 'checked' => false, 'catatan' => ''],
    ];

    public function index(Request $request)
    {
        $query = Maintenance::with(['perangkat', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }
        if ($request->filled('perangkat_id')) {
            $query->where('perangkat_id', $request->perangkat_id);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('perangkat', function ($qb) use ($q) {
                $qb->where('nama_perangkat', 'like', "%$q%")
                    ->orWhere('kode_perangkat', 'like', "%$q%");
            });
        }

        $maintenances = $query->latest()->paginate(10)->withQueryString();
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();
        $checklistTemplate = self::CHECKLIST_TEMPLATE;

        return view('maintenance.index', compact('maintenances', 'perangkatList', 'checklistTemplate'));
    }

    public function create()
    {
        $perangkatList = Perangkat::orderBy('nama_perangkat')->get();
        $checklistTemplate = self::CHECKLIST_TEMPLATE;
        return view('maintenance.create', compact('perangkatList', 'checklistTemplate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'perangkat_id' => 'required|exists:perangkat,id',
            'tanggal'      => 'required|date',
            'periode'      => 'required|in:Harian,Mingguan,Bulanan,Tahunan',
            'status'       => 'required|in:Dijadwalkan,Dalam Proses,Selesai,Ditunda',
            'keterangan'   => 'nullable|string',
            'eviden'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'checklist'    => 'nullable|array',
        ]);

        // Proses checklist
        $checklist = [];
        if ($request->filled('checklist')) {
            foreach ($request->checklist as $key => $item) {
                $checklist[] = [
                    'item'    => $item['item'] ?? '',
                    'checked' => isset($item['checked']) && $item['checked'] == '1',
                    'catatan' => $item['catatan'] ?? '',
                ];
            }
        }

        if ($request->hasFile('eviden')) {
            $validated['eviden'] = $request->file('eviden')->store('eviden', 'public');
        }

        $validated['checklist'] = $checklist;
        $validated['user_id']   = auth()->id();

        Maintenance::create($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil disimpan.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load(['perangkat', 'user']);
        return view('maintenance.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $perangkatList     = Perangkat::orderBy('nama_perangkat')->get();
        $checklistTemplate = self::CHECKLIST_TEMPLATE;
        return view('maintenance.edit', compact('maintenance', 'perangkatList', 'checklistTemplate'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'perangkat_id' => 'required|exists:perangkat,id',
            'tanggal'      => 'required|date',
            'periode'      => 'required|in:Harian,Mingguan,Bulanan,Tahunan',
            'status'       => 'required|in:Dijadwalkan,Dalam Proses,Selesai,Ditunda',
            'keterangan'   => 'nullable|string',
            'eviden'       => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'checklist'    => 'nullable|array',
        ]);

        $checklist = [];
        if ($request->filled('checklist')) {
            foreach ($request->checklist as $key => $item) {
                $checklist[] = [
                    'item'    => $item['item'] ?? '',
                    'checked' => isset($item['checked']) && $item['checked'] == '1',
                    'catatan' => $item['catatan'] ?? '',
                ];
            }
        }

        if ($request->hasFile('eviden')) {
            if ($maintenance->eviden) {
                Storage::disk('public')->delete($maintenance->eviden);
            }
            $validated['eviden'] = $request->file('eviden')->store('eviden', 'public');
        }

        $validated['checklist'] = $checklist;

        $maintenance->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        if ($maintenance->eviden) {
            Storage::disk('public')->delete($maintenance->eviden);
        }
        $maintenance->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Data maintenance berhasil dihapus.');
    }
}
