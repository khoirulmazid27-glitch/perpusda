<?php

namespace App\Imports;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Pendidikan;
use App\Models\JenisKontrak;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Http\UploadedFile;

use Carbon\Carbon;
class KaryawanImport
{
    public array $errors = [];
    public int $imported = 0;

    public function import(UploadedFile $file): void
    {
        SimpleExcelReader::create($file->getPathname(), 'xlsx')
            ->getRows()
            ->each(function (array $row) {
                try {
                    $jabatan    = Jabatan::whereRaw('LOWER(nama_jabatan) = ?', [strtolower($row['jabatan'] ?? '')])->first();
                    $pendidikan = Pendidikan::whereRaw('LOWER(nama_pendidikan) = ?', [strtolower($row['pendidikan'] ?? '')])->first();
                    $kontrak    = JenisKontrak::whereRaw('LOWER(nama_kontrak) = ?', [strtolower($row['jenis_kontrak'] ?? '')])->first();

                    // Skip baris kosong
                    if (empty($row['nama_lengkap']) || empty($row['nip'])) return;

                    Karyawan::updateOrCreate(
                        ['nip' => (string) $row['nip']],
                        [
                            'nama_lengkap'          => $row['nama_lengkap'],
                            'nik'                   => (string) ($row['nik'] ?? ''),
                            'tanggal_masuk'         => \Carbon\Carbon::parse($row['tgl_masuk'])->format('Y-m-d'),
                            'tanggal_mulai_jabatan' => \Carbon\Carbon::parse($row['tgl_mulai_jabatan'])->format('Y-m-d'),
                            'alamat'                => $row['alamat'] ?? null,
                            'agama'                 => $row['agama'] ?? null,
                            'golongan_darah'        => $row['golongan_darah'] ?? null,
                            'id_jabatan'            => $jabatan?->id_jabatan,
                            'id_pendidikan'         => $pendidikan?->id_pendidikan,
                            'id_jenis_kontrak'      => $kontrak?->id_jenis_kontrak,
                            'status_aktif'          => $row['status'] ?? 'Aktif',
                            'gaji'                  => (float) str_replace(['.', ','], ['', '.'], $row['gaji'] ?? 0),
                        ]
                    );

                    $this->imported++;
                } catch (\Throwable $e) {
                    $this->errors[] = "Baris NIP {$row['nip']}: " . $e->getMessage();
                }
            });
    }
}
