<x-layouts.app title="Daftar Pasien Periksa">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Daftar Pasien Periksa</h2>
    </div>

    <div class="card bg-base-100 shadow-md rounded-2xl border">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">

                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">No. Antrian</th>
                            <th class="px-6 py-4">Nama Pasien</th>
                            <th class="px-6 py-4">No. RM</th>
                            <th class="px-6 py-4">Hari / Jadwal</th>
                            <th class="px-6 py-4">Keluhan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-slate-700">
                        @forelse($daftarPolis as $item)
                        @php $sudahDiperiksa = $item->periksas->isNotEmpty(); @endphp
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-bold text-center text-lg text-primary">
                                {{ $item->no_antrian }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $item->pasien->nama ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-500 text-xs font-mono">
                                {{ $item->pasien->no_rm ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-semibold">{{ $item->jadwalPeriksa->hari ?? '-' }}</span>
                                <br>
                                <span class="text-xs text-slate-400">
                                    {{ $item->jadwalPeriksa->jam_mulai ?? '' }} – {{ $item->jadwalPeriksa->jam_selesai ?? '' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 max-w-[200px] truncate text-slate-600">
                                {{ $item->keluhan ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @if($sudahDiperiksa)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="fas fa-circle-check text-[10px]"></i> Sudah Diperiksa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        <i class="fas fa-clock text-[10px]"></i> Menunggu
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if(!$sudahDiperiksa)
                                    <a href="{{ route('dokter.periksa.create', $item->id) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-primary hover:bg-primary/90
                                               text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-stethoscope text-xs"></i>
                                        Periksa
                                    </a>
                                @else
                                    <a href="{{ route('dokter.periksa.create', $item->id) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-slate-200 hover:bg-slate-300
                                               text-slate-600 text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-eye text-xs"></i>
                                        Detail
                                    </a>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada pasien yang mendaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</x-layouts.app>
