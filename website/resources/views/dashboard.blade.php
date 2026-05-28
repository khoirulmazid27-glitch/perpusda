
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- ── Inject Chart.js sekali di head ── --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ══════════════════════════════════════════════════════
                 BARIS 1 — Kartu Statistik Utama
            ══════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- Total Karyawan --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 100-4 2 2 0 000 4zM3 16a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Karyawan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalKaryawan) }}</p>
                    </div>
                </div>

                {{-- Karyawan Aktif --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Aktif</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($karyawanAktif) }}</p>
                    </div>
                </div>

                {{-- Karyawan Cuti --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Cuti</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format($karyawanCuti) }}</p>
                    </div>
                </div>

                {{-- Pensiun & Resign --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pensiun / Resign</p>
                        <p class="text-2xl font-bold text-red-500">{{ number_format($karyawanPensiun + $karyawanResign) }}</p>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 BARIS 2 — Info Gaji + Info Master Data
            ══════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Total Gaji --}}
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-sm p-5 text-white">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-200">Total Gaji Aktif</p>
                    <p class="text-3xl font-extrabold mt-1">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-200 mt-2">Rata-rata: Rp {{ number_format($rataRataGaji, 0, ',', '.') }} / orang</p>
                </div>

                {{-- Master Data Cards --}}
                <div class="col-span-1 md:col-span-2 grid grid-cols-3 gap-4">

                    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 text-center">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalJabatan }}</p>
                        <p class="text-xs text-gray-500 mt-1">Jabatan</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 text-center">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalPendidikan }}</p>
                        <p class="text-xs text-gray-500 mt-1">Pendidikan</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 text-center">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalJenisKontrak }}</p>
                        <p class="text-xs text-gray-500 mt-1">Jenis Kontrak</p>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 BARIS 3 — Chart: Karyawan Masuk per Bulan
            ══════════════════════════════════════════════════════ --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">
                    Karyawan Masuk — 12 Bulan Terakhir
                </h3>
                <div class="relative h-52">
                    <canvas id="chartBulan"></canvas>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 BARIS 4 — Chart Jabatan + Chart Pendidikan & Kontrak
            ══════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Chart per Jabatan (Bar horizontal) --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">
                        Distribusi per Jabatan
                    </h3>
                    <div class="relative h-56">
                        <canvas id="chartJabatan"></canvas>
                    </div>
                </div>

                {{-- Chart Pendidikan (Doughnut) + Kontrak (list) --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 space-y-5">

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">
                            Distribusi per Pendidikan
                        </h3>
                        <div class="flex items-center gap-6">
                            <div class="relative w-36 h-36 flex-shrink-0">
                                <canvas id="chartPendidikan"></canvas>
                            </div>
                            <ul class="text-xs text-gray-600 space-y-1 flex-1">
                                @foreach ($karyawanPerPendidikan as $item)
                                <li class="flex justify-between">
                                    <span class="truncate">{{ $item->nama_pendidikan }}</span>
                                    <span class="font-semibold text-gray-800 ml-2">{{ $item->total }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-3">
                            Jenis Kontrak
                        </h3>
                        <ul class="space-y-2">
                            @foreach ($karyawanPerKontrak as $item)
                            @php
                                $pct = $totalKaryawan > 0 ? round($item->total / $totalKaryawan * 100) : 0;
                            @endphp
                            <li>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-600">{{ $item->nama_kontrak }}</span>
                                    <span class="font-semibold text-gray-800">{{ $item->total }} ({{ $pct }}%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════
                 BARIS 5 — Tabel Karyawan Terbaru
            ══════════════════════════════════════════════════════ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Karyawan Terbaru
                    </h3>
                    {{-- <a href="{{ route('karyawan.index') }}" class="text-xs text-blue-600 hover:underline font-medium">
                        Lihat Semua →
                    </a> --}}
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">NIP</th>
                                <th class="px-6 py-3 text-left">Jabatan</th>
                                <th class="px-6 py-3 text-left">Kontrak</th>
                                <th class="px-6 py-3 text-left">Tgl Masuk</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($karyawanTerbaru as $k)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $k->nama_lengkap }}</td>
                                <td class="px-6 py-3 text-gray-500 font-mono text-xs">{{ $k->nip }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->jabatan?->nama_jabatan ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->jenisKontrak?->nama_kontrak ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ \Carbon\Carbon::parse($k->tanggal_masuk)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $badge = match($k->status_aktif) {
                                            'Aktif'   => 'bg-green-100 text-green-700',
                                            'Cuti'    => 'bg-yellow-100 text-yellow-700',
                                            'Pensiun' => 'bg-gray-100 text-gray-600',
                                            'Resign'  => 'bg-red-100 text-red-600',
                                            default   => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                                        {{ $k->status_aktif }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-400 text-sm">
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /max-w-7xl --}}
    </div>{{-- /py-8 --}}

    {{-- ══════════════════════════════════════════════════════
         Scripts Chart.js
    ══════════════════════════════════════════════════════ --}}
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Palet warna ────────────────────────────────────────
        const palette = [
            '#3b82f6','#6366f1','#8b5cf6','#ec4899',
            '#f59e0b','#10b981','#14b8a6','#f43f5e',
        ];

        // ── 1. Chart Karyawan per Bulan (Line) ─────────────────
        const bulanLabels = @json($karyawanPerBulan->pluck('label'));
        const bulanData   = @json($karyawanPerBulan->pluck('total'));

        new Chart(document.getElementById('chartBulan'), {
            type: 'line',
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: 'Karyawan Masuk',
                    data: bulanData,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.12)',
                    borderWidth: 2,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 } },
                        grid: { color: '#f3f4f6' },
                    },
                    x: { ticks: { font: { size: 11 } }, grid: { display: false } },
                },
            },
        });

        // ── 2. Chart Karyawan per Jabatan (Bar horizontal) ─────
        const jabatanLabels = @json($karyawanPerJabatan->pluck('nama_jabatan'));
        const jabatanData   = @json($karyawanPerJabatan->pluck('total'));

        new Chart(document.getElementById('chartJabatan'), {
            type: 'bar',
            data: {
                labels: jabatanLabels,
                datasets: [{
                    label: 'Jumlah',
                    data: jabatanData,
                    backgroundColor: palette.slice(0, jabatanData.length),
                    borderRadius: 6,
                    borderSkipped: false,
                }],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 } },
                        grid: { color: '#f3f4f6' },
                    },
                    y: { ticks: { font: { size: 11 } }, grid: { display: false } },
                },
            },
        });

        // ── 3. Chart Pendidikan (Doughnut) ─────────────────────
        const pendLabels = @json($karyawanPerPendidikan->pluck('nama_pendidikan'));
        const pendData   = @json($karyawanPerPendidikan->pluck('total'));

        new Chart(document.getElementById('chartPendidikan'), {
            type: 'doughnut',
            data: {
                labels: pendLabels,
                datasets: [{
                    data: pendData,
                    backgroundColor: palette.slice(0, pendData.length),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                    }},
                },
            },
        });

    });
    </script>
    @endpush

</x-app-layout>
