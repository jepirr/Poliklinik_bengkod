<x-layouts.app title="Form Pemeriksaan">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dokter.periksa.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Form Pemeriksaan</h2>
    </div>

    @php $sudahDiperiksa = $daftarPoli->periksas->isNotEmpty(); @endphp

    @if($sudahDiperiksa)
        {{-- MODE: LIHAT HASIL --}}
        @php $periksa = $daftarPoli->periksas->first(); @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Info Pasien --}}
            <div class="card bg-base-100 shadow-md rounded-2xl border p-6">
                <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Info Pasien</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-slate-400">Nama</span>
                        <p class="font-semibold text-slate-800">{{ $daftarPoli->pasien->nama }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">No. RM</span>
                        <p class="font-mono font-semibold text-slate-800">{{ $daftarPoli->pasien->no_rm ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">No. Antrian</span>
                        <p class="text-2xl font-black text-primary">{{ $daftarPoli->no_antrian }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Keluhan</span>
                        <p class="text-slate-700">{{ $daftarPoli->keluhan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Hasil Pemeriksaan --}}
            <div class="lg:col-span-2 card bg-base-100 shadow-md rounded-2xl border p-6">
                <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Hasil Pemeriksaan</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-slate-400">Tanggal Periksa</span>
                        <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Catatan Dokter</span>
                        <p class="text-slate-700 bg-slate-50 rounded-lg p-3 mt-1">{{ $periksa->catatan ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Obat Diberikan</span>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @forelse($periksa->detailPeriksas as $detail)
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <i class="fas fa-pills text-[10px]"></i>
                                    {{ $detail->obat->nama_obat ?? '-' }}
                                    ({{ $detail->obat->kemasan ?? '-' }})
                                </span>
                            @empty
                                <span class="text-slate-400">Tidak ada obat</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="pt-2 border-t border-slate-100">
                        <span class="text-slate-400">Total Biaya</span>
                        <p class="text-2xl font-black text-green-600">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

        </div>

    @else
        {{-- MODE: FORM INPUT --}}
        <form action="{{ route('dokter.periksa.store', $daftarPoli->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Info Pasien --}}
                <div class="card bg-base-100 shadow-md rounded-2xl border p-6">
                    <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Info Pasien</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-slate-400">Nama</span>
                            <p class="font-semibold text-slate-800">{{ $daftarPoli->pasien->nama }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400">No. RM</span>
                            <p class="font-mono font-semibold text-slate-800">{{ $daftarPoli->pasien->no_rm ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400">No. Antrian</span>
                            <p class="text-2xl font-black text-primary">{{ $daftarPoli->no_antrian }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400">Jadwal</span>
                            <p class="font-semibold text-slate-800">
                                {{ $daftarPoli->jadwalPeriksa->hari ?? '-' }},
                                {{ $daftarPoli->jadwalPeriksa->jam_mulai ?? '' }}–{{ $daftarPoli->jadwalPeriksa->jam_selesai ?? '' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-slate-400">Keluhan</span>
                            <p class="text-slate-700 bg-slate-50 rounded-lg p-2 mt-1">{{ $daftarPoli->keluhan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Form Pemeriksaan --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Catatan --}}
                    <div class="card bg-base-100 shadow-md rounded-2xl border p-6">
                        <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Catatan Dokter</h3>
                        <textarea name="catatan" rows="4"
                            class="w-full border-2 border-slate-200 rounded-xl p-3 text-sm focus:border-primary focus:outline-none resize-none"
                            placeholder="Tulis diagnosis dan catatan pemeriksaan...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilih Obat --}}
                    <div class="card bg-base-100 shadow-md rounded-2xl border p-6">
                        <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">
                            Pilih Obat
                            <span class="text-slate-400 font-normal normal-case text-xs ml-1">(bisa lebih dari satu)</span>
                        </h3>

                        @if($obats->isEmpty())
                            <p class="text-slate-400 text-sm">Belum ada data obat.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="obatList">
                                @foreach($obats as $obat)
                                <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-slate-100 hover:border-primary/40
                                              cursor-pointer transition obat-item" data-harga="{{ $obat->harga }}">
                                    <input type="checkbox" name="obat[]" value="{{ $obat->id }}"
                                        class="checkbox checkbox-primary checkbox-sm obat-check"
                                        {{ in_array($obat->id, old('obat', [])) ? 'checked' : '' }}>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $obat->nama_obat }}</p>
                                        <p class="text-xs text-slate-400">
                                            {{ $obat->kemasan ?? '-' }} &bull;
                                            <span class="text-green-600 font-semibold">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Biaya Periksa --}}
                    <div class="card bg-base-100 shadow-md rounded-2xl border p-6">
                        <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Total Biaya Periksa</h3>
                        <div class="flex items-center border-2 border-slate-200 rounded-xl px-4 py-3 focus-within:border-primary">
                            <span class="text-slate-500 font-semibold text-sm mr-2">Rp</span>
                            <input type="number" name="biaya_periksa" id="biayaInput"
                                value="{{ old('biaya_periksa', 50000) }}"
                                min="0" step="1000"
                                class="w-full focus:outline-none text-slate-800 font-bold text-lg" required>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">
                            <i class="fas fa-circle-info"></i>
                            Biaya dihitung otomatis dari obat yang dipilih + biaya jasa Rp 50.000. Bisa diubah manual.
                        </p>
                        @error('biaya_periksa')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex gap-3">
                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-primary hover:bg-primary/90 text-white font-semibold text-sm transition">
                            <i class="fas fa-floppy-disk mr-2"></i>
                            Simpan Pemeriksaan
                        </button>
                        <a href="{{ route('dokter.periksa.index') }}"
                            class="px-8 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                            Batal
                        </a>
                    </div>

                </div>
            </div>
        </form>
    @endif

    @push('scripts')
    <script>
        const BASE_BIAYA = 50000;
        const biayaInput = document.getElementById('biayaInput');
        const checks = document.querySelectorAll('.obat-check');

        function hitungBiaya() {
            let total = BASE_BIAYA;
            checks.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.closest('.obat-item').dataset.harga) || 0;
                }
            });
            biayaInput.value = total;
        }

        checks.forEach(cb => cb.addEventListener('change', hitungBiaya));
    </script>
    @endpush

</x-layouts.app>
