<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('karyawan.index') }}"
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Karyawan</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data" x-data="fotoPreview()">

                @csrf

                <div class="space-y-5">

                    {{-- ── Foto Profil ──────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Foto Profil</h3>
                        <div class="flex items-center gap-6">
                            {{-- Preview --}}
                            <div class="flex-shrink-0">
                                <template x-if="preview">
                                    <img :src="preview" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-gray-100">
                                </template>
                                <template x-if="!preview">
                                    <div class="w-24 h-24 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-medium rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Pilih Foto
                                    <input type="file" name="foto" accept="image/*" class="hidden"
                                           @change="onFileChange($event)">
                                </label>
                                <p class="text-xs text-gray-400 mt-2">JPG, PNG, WEBP · Maks 2 MB</p>
                                @error('foto')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Data Pribadi ─────────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-5">Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <x-form-field label="Nama Lengkap" name="nama_lengkap" required>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                       value="{{ old('nama_lengkap') }}"
                                       class="form-input @error('nama_lengkap') border-red-400 @enderror"
                                       placeholder="Nama sesuai KTP">
                            </x-form-field>

                            <x-form-field label="NIK" name="nik" required>
                                <input type="text" name="nik" id="nik"
                                       value="{{ old('nik') }}"
                                       maxlength="20"
                                       class="form-input @error('nik') border-red-400 @enderror"
                                       placeholder="16 digit NIK">
                            </x-form-field>

                            <x-form-field label="NIP" name="nip" required>
                                <input type="text" name="nip" id="nip"
                                       value="{{ old('nip') }}"
                                       maxlength="50"
                                       class="form-input @error('nip') border-red-400 @enderror"
                                       placeholder="Nomor Induk Pegawai">
                            </x-form-field>

                            <x-form-field label="Agama" name="agama">
                                <select name="agama" class="form-input">
                                    <option value="">— Pilih Agama —</option>
                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                    <option value="{{ $ag }}" {{ old('agama') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <x-form-field label="Golongan Darah" name="golongan_darah">
                                <select name="golongan_darah" class="form-input">
                                    <option value="">— Pilih —</option>
                                    @foreach(['A','B','AB','O'] as $gd)
                                    <option value="{{ $gd }}" {{ old('golongan_darah') == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <div class="md:col-span-2">
                                <x-form-field label="Alamat" name="alamat">
                                    <textarea name="alamat" rows="3"
                                              class="form-input resize-none @error('alamat') border-red-400 @enderror"
                                              placeholder="Alamat lengkap sesuai KTP">{{ old('alamat') }}</textarea>
                                </x-form-field>
                            </div>
                        </div>
                    </div>

                    {{-- ── Data Kepegawaian ─────────────────────────────────── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-5">Data Kepegawaian</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <x-form-field label="Jabatan" name="id_jabatan">
                                <select name="id_jabatan" class="form-input @error('id_jabatan') border-red-400 @enderror">
                                    <option value="">— Pilih Jabatan —</option>
                                    @foreach ($jabatans as $j)
                                    <option value="{{ $j->id_jabatan }}" {{ old('id_jabatan') == $j->id_jabatan ? 'selected' : '' }}>
                                        {{ $j->nama_jabatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <x-form-field label="Pendidikan" name="id_pendidikan">
                                <select name="id_pendidikan" class="form-input @error('id_pendidikan') border-red-400 @enderror">
                                    <option value="">— Pilih Pendidikan —</option>
                                    @foreach ($pendidikans as $p)
                                    <option value="{{ $p->id_pendidikan }}" {{ old('id_pendidikan') == $p->id_pendidikan ? 'selected' : '' }}>
                                        {{ $p->nama_pendidikan }}
                                    </option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <x-form-field label="Jenis Kontrak" name="id_jenis_kontrak">
                                <select name="id_jenis_kontrak" class="form-input @error('id_jenis_kontrak') border-red-400 @enderror">
                                    <option value="">— Pilih Jenis Kontrak —</option>
                                    @foreach ($kontraks as $kt)
                                    <option value="{{ $kt->id_jenis_kontrak }}" {{ old('id_jenis_kontrak') == $kt->id_jenis_kontrak ? 'selected' : '' }}>
                                        {{ $kt->nama_kontrak }}
                                    </option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <x-form-field label="Status Kepegawaian" name="status_aktif" required>
                                <select name="status_aktif" class="form-input @error('status_aktif') border-red-400 @enderror">
                                    @foreach(['Aktif','Cuti','Pensiun','Resign'] as $s)
                                    <option value="{{ $s }}" {{ old('status_aktif', 'Aktif') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </x-form-field>

                            <x-form-field label="Tanggal Masuk" name="tanggal_masuk" required>
                                <input type="date" name="tanggal_masuk"
                                       value="{{ old('tanggal_masuk') }}"
                                       class="form-input @error('tanggal_masuk') border-red-400 @enderror">
                            </x-form-field>

                            <x-form-field label="Tanggal Mulai Jabatan" name="tanggal_mulai_jabatan" required>
                                <input type="date" name="tanggal_mulai_jabatan"
                                       value="{{ old('tanggal_mulai_jabatan') }}"
                                       class="form-input @error('tanggal_mulai_jabatan') border-red-400 @enderror">
                            </x-form-field>

                            <div class="md:col-span-2">
                                <x-form-field label="Gaji (Rp)" name="gaji" required>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                        <input type="number" name="gaji" min="0" step="1000"
                                               value="{{ old('gaji', 0) }}"
                                               class="form-input pl-10 @error('gaji') border-red-400 @enderror"
                                               placeholder="0">
                                    </div>
                                </x-form-field>
                            </div>
                        </div>
                    </div>

                    {{-- ── Tombol Aksi ──────────────────────────────────────── --}}
                    <div class="flex items-center justify-end gap-3 pb-4">
                        <a href="{{ route('karyawan.index') }}"
                           class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                            Simpan Karyawan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
    function fotoPreview() {
        return {
            preview: null,
            onFileChange(e) {
                const file = e.target.files[0];
                if (!file) { this.preview = null; return; }
                const reader = new FileReader();
                reader.onload = (ev) => this.preview = ev.target.result;
                reader.readAsDataURL(file);
            }
        };
    }
    </script>

    {{-- CSS helper classes --}}
    <style>
    .form-input {
        @apply w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl
               focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none
               bg-white text-gray-800 transition-shadow;
    }
    </style>
    @endpush

</x-app-layout>
