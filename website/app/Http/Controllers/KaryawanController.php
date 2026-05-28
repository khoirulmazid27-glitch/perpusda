<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Pendidikan;
use App\Models\JenisKontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;
use App\Imports\KaryawanImport;
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Karyawan::with(['jabatan', 'pendidikan', 'jenisKontrak']);

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nip', 'like', "%{$s}%")
                  ->orWhere('nik', 'like', "%{$s}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status);
        }

        // Filter jabatan
        if ($request->filled('jabatan')) {
            $query->where('id_jabatan', $request->jabatan);
        }

        // Filter jenis kontrak
        if ($request->filled('kontrak')) {
            $query->where('id_jenis_kontrak', $request->kontrak);
        }

        $karyawans    = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        $jabatans     = Jabatan::orderBy('nama_jabatan')->get();
        $kontraks     = JenisKontrak::orderBy('nama_kontrak')->get();

        return view('karyawan.index', compact('karyawans', 'jabatans', 'kontraks'));
    }

    // ── CREATE ───────────────────────────────────────────────────────────────

    public function create()
    {
        $jabatans    = Jabatan::orderBy('nama_jabatan')->get();
        $pendidikans = Pendidikan::orderBy('nama_pendidikan')->get();
        $kontraks    = JenisKontrak::orderBy('nama_kontrak')->get();

        return view('karyawan.create', compact('jabatans', 'pendidikans', 'kontraks'));
    }

    // ── STORE ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('karyawan/foto', 'public');
        }

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    // ── SHOW ─────────────────────────────────────────────────────────────────

    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['jabatan', 'pendidikan', 'jenisKontrak']);
        return view('karyawan.show', compact('karyawan'));
    }

    // ── EDIT ─────────────────────────────────────────────────────────────────

    public function edit(Karyawan $karyawan)
    {
        $jabatans    = Jabatan::orderBy('nama_jabatan')->get();
        $pendidikans = Pendidikan::orderBy('nama_pendidikan')->get();
        $kontraks    = JenisKontrak::orderBy('nama_kontrak')->get();

        return view('karyawan.edit', compact('karyawan', 'jabatans', 'pendidikans', 'kontraks'));
    }

    // ── UPDATE ───────────────────────────────────────────────────────────────

    // ── UPDATE ───────────────────────────────────────────────────────────────

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate($this->rules($karyawan->id_karyawan));

        if ($request->hasFile('foto')) {
            // Ada foto baru → hapus foto lama dulu, simpan yang baru
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('karyawan/foto', 'public');

        } elseif ($request->input('hapus_foto') === '1') {
            // User klik "Hapus Foto" tanpa upload baru → hapus saja
            if ($karyawan->foto) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $validated['foto'] = null;

        } else {
            // Tidak ada perubahan foto → pertahankan foto lama
            unset($validated['foto']);
        }

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    // ── DESTROY ──────────────────────────────────────────────────────────────

    public function destroy(Karyawan $karyawan)
    {
        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
        }
        $karyawan->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }

    // ── EXPORT EXCEL ─────────────────────────────────────────────────────────

    // Export Excel
public function exportExcel(Request $request)
{
    $export = new \App\Exports\KaryawanExport($request->all());
    return $export->download('karyawan_' . now()->format('Ymd_His') . '.xlsx');
}

// Import Excel
public function importExcel(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls|max:5120',
    ]);

    $import = new \App\Imports\KaryawanImport();
    $import->import($request->file('file'));

    $msg = "Import berhasil: {$import->imported} data.";
    if (!empty($import->errors)) {
        $msg .= ' Gagal: ' . implode('; ', $import->errors);
    }

    return redirect()->route('karyawan.index')->with('success', $msg);
}

    // ── EXPORT PDF ───────────────────────────────────────────────────────────

    public function exportPdf(Request $request)
    {
        $query = Karyawan::with(['jabatan', 'pendidikan', 'jenisKontrak']);

        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status);
        }
        if ($request->filled('jabatan')) {
            $query->where('id_jabatan', $request->jabatan);
        }

        $karyawans = $query->orderBy('nama_lengkap')->get();

        $pdf = Pdf::loadView('karyawan.pdf', compact('karyawans'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('karyawan_' . now()->format('Ymd_His') . '.pdf');
    }

    // ── IMPORT EXCEL ─────────────────────────────────────────────────────────



    // ── HAPUS FOTO ───────────────────────────────────────────────────────────

    public function deleteFoto(Karyawan $karyawan)
    {
        if ($karyawan->foto) {
            Storage::disk('public')->delete($karyawan->foto);
            $karyawan->update(['foto' => null]);
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    // ── Rules ─────────────────────────────────────────────────────────────────

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nama_lengkap'          => 'required|string|max:255',
            'nip'                   => ['required', 'string', 'max:50', Rule::unique('karyawans', 'nip')->ignore($ignoreId, 'id_karyawan')],
            'nik'                   => ['required', 'string', 'max:20', Rule::unique('karyawans', 'nik')->ignore($ignoreId, 'id_karyawan')],
            'tanggal_masuk'         => 'required|date',
            'tanggal_mulai_jabatan' => 'required|date',
            'alamat'                => 'nullable|string',
            'agama'                 => 'nullable|string|max:50',
            'golongan_darah'        => 'nullable|string|max:2',
            'id_jabatan'            => 'nullable|exists:jabatans,id_jabatan',
            'id_pendidikan'         => 'nullable|exists:pendidikans,id_pendidikan',
            'id_jenis_kontrak'      => 'nullable|exists:jenis_kontraks,id_jenis_kontrak',
            'status_aktif'          => 'required|in:Aktif,Cuti,Pensiun,Resign',
            'gaji'                  => 'required|numeric|min:0',
            'foto'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
