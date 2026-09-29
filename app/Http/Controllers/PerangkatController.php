<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerangkatController extends Controller
{
    public function index(Request $request)
    {
        $query = Perangkat::query();

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis_perangkat', $request->jenis);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('nama_perangkat', 'like', "%$q%")
                    ->orWhere('kode_perangkat', 'like', "%$q%")
                    ->orWhere('lokasi', 'like', "%$q%");
            });
        }

        $perangkat = $query->latest()->paginate(10)->withQueryString();
        $jenisPerangkat = Perangkat::select('jenis_perangkat')->distinct()->pluck('jenis_perangkat');

        return view('perangkat.index', compact('perangkat', 'jenisPerangkat'));
    }

    public function create()
    {
        return view('perangkat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_perangkat'  => 'required|string|unique:perangkat',
            'nama_perangkat'  => 'required|string|max:255',
            'jenis_perangkat' => 'required|string|max:100',
            'merk'            => 'nullable|string|max:100',
            'model'           => 'nullable|string|max:100',
            'no_seri'         => 'nullable|string|max:100',
            'lokasi'          => 'required|string|max:255',
            'ruangan'         => 'nullable|string|max:100',
            'tanggal_install' => 'nullable|date',
            'kondisi'         => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status'          => 'required|in:Aktif,Tidak Aktif,Dalam Perbaikan',
            'keterangan'      => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        Perangkat::create($validated);

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function show(Perangkat $perangkat)
    {
        $riwayat = $perangkat->maintenances()->with('user')->latest()->paginate(10);
        return view('perangkat.show', compact('perangkat', 'riwayat'));
    }

    public function edit(Perangkat $perangkat)
    {
        return view('perangkat.edit', compact('perangkat'));
    }

    public function update(Request $request, Perangkat $perangkat)
    {
        $validated = $request->validate([
            'kode_perangkat'  => 'required|string|unique:perangkat,kode_perangkat,' . $perangkat->id,
            'nama_perangkat'  => 'required|string|max:255',
            'jenis_perangkat' => 'required|string|max:100',
            'merk'            => 'nullable|string|max:100',
            'model'           => 'nullable|string|max:100',
            'no_seri'         => 'nullable|string|max:100',
            'lokasi'          => 'required|string|max:255',
            'ruangan'         => 'nullable|string|max:100',
            'tanggal_install' => 'nullable|date',
            'kondisi'         => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status'          => 'required|in:Aktif,Tidak Aktif,Dalam Perbaikan',
            'keterangan'      => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($perangkat->foto) {
                Storage::disk('public')->delete($perangkat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        $perangkat->update($validated);

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy(Perangkat $perangkat)
    {
        if ($perangkat->foto) {
            Storage::disk('public')->delete($perangkat->foto);
        }
        $perangkat->delete();

        return redirect()->route('perangkat.index')
            ->with('success', 'Perangkat berhasil dihapus.');
    }
}
