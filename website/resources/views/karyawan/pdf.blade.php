<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #2563eb; }
        .header h1 { font-size: 16px; font-weight: bold; color: #1e3a8a; }
        .header p { font-size: 10px; color: #6b7280; margin-top: 3px; }
        .meta { font-size: 9px; color: #9ca3af; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #2563eb; color: #fff;
            padding: 7px 8px; text-align: left;
            font-size: 9px; text-transform: uppercase; letter-spacing: .5px;
        }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .badge {
            display: inline-block; padding: 1px 6px; border-radius: 99px;
            font-size: 9px; font-weight: bold;
        }
        .badge-aktif   { background: #dcfce7; color: #15803d; }
        .badge-cuti    { background: #fef9c3; color: #b45309; }
        .badge-pensiun { background: #f3f4f6; color: #6b7280; }
        .badge-resign  { background: #fee2e2; color: #b91c1c; }
        .footer { margin-top: 16px; font-size: 9px; color: #9ca3af; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Karyawan</h1>
        <p>Dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
    <div class="meta">Total: {{ $karyawans->count() }} karyawan</div>

    <table>
        <thead>
            <tr>
                <th style="width:25px">#</th>
                <th>Nama Lengkap</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Kontrak</th>
                <th>Pendidikan</th>
                <th>Tgl Masuk</th>
                <th style="text-align:right">Gaji</th>
                <th style="text-align:center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $i => $k)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $k->nama_lengkap }}</td>
                <td style="font-family:monospace;font-size:9px">{{ $k->nip }}</td>
                <td>{{ $k->jabatan?->nama_jabatan ?? '-' }}</td>
                <td>{{ $k->jenisKontrak?->nama_kontrak ?? '-' }}</td>
                <td>{{ $k->pendidikan?->nama_pendidikan ?? '-' }}</td>
                <td>{{ $k->tanggal_masuk?->format('d/m/Y') }}</td>
                <td style="text-align:right">{{ number_format($k->gaji, 0, ',', '.') }}</td>
                <td style="text-align:center">
                    @php $cls = strtolower($k->status_aktif); @endphp
                    <span class="badge badge-{{ $cls }}">{{ $k->status_aktif }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Sistem Informasi Kepegawaian</div>
</body>
</html>
