<x-layouts.app title="Riwayat Pemeriksaan">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Riwayat Pemeriksaan</h2>
        <a href="{{ route('pasien.daftar') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-semibold rounded-xl transition">
            <i class="fas fa-plus text-xs"></i>
            Daftar Periksa Baru
        </a>
    </div>

    @if($riwayat->isEmpty())
        <div class="card bg-base-100 shadow-md rounded-2xl border">
            <div class="card-body py-16 text-center text-slate-400">
                <i class="fas fa-notes-medical text-4xl mb-3 block"></i>
                <p class="text-sm">Belum ada riwayat pemeriksaan</p>
            </div>
        </div>
    @else
        <div class="space-y-5">
            @foreach($riwayat as $item)
            @php $periksa = $item->periksas->first(); @endphp

            <div class="card bg-base-100 shadow-md rounded-2xl border">
                <div class="card-body p-6">

                    {{-- Header card --}}
                    <div class="flex items-start justify-between flex-wrap gap-3 mb-4">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider mb-0.5">Tanggal Periksa</p>
                            <p class="font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->isoFormat('dddd, D MMMM YYYY') }}
                                &bull;
                                <span class="text-slate-500 font-normal">{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('H:i') }} WIB</span>
                            </p>
                        </div>
                        <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            <i class="fas fa-circle-check text-[10px]"></i> Selesai
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">

                        <div>
                            <span class="text-slate-400 text-xs">Dokter</span>
                            <p class="font-semibold text-slate-800 mt-0.5">
                                dr. {{ $item->jadwalPeriksa->dokter->nama ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-slate-400 text-xs">Keluhan</span>
                            <p class="text-slate-700 mt-0.5">{{ $item->keluhan ?? '-' }}</p>
                        </div>

                        <div>
                            <span class="text-slate-400 text-xs">Catatan Dokter</span>
                            <p class="text-slate-700 mt-0.5">{{ $periksa->catatan ?? '-' }}</p>
                        </div>

                        <div>
                            <span class="text-slate-400 text-xs">Total Biaya</span>
                            <p class="text-xl font-black text-green-600 mt-0.5">
                                Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                    {{-- Obat --}}
                    @if($periksa->detailPeriksas->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Obat yang Diberikan</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($periksa->detailPeriksas as $detail)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                                <i class="fas fa-pills text-[10px]"></i>
                                {{ $detail->obat->nama_obat ?? '-' }}
                                @if($detail->obat && $detail->obat->kemasan)
                                    <span class="text-blue-400">({{ $detail->obat->kemasan }})</span>
                                @endif
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            @endforeach
        </div>
    @endif

</x-layouts.app>
