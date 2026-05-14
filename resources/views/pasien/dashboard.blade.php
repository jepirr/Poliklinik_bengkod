<x-layouts.app title="Dashboard Pasien">
    <div class="p-6 bg-slate-50 min-h-screen">
        <header class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Halo, {{ Auth::user()->nama }}!</h1>
            <p class="text-slate-500">Selamat datang di sistem layanan Poliklinik.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card bg-white shadow-sm border border-slate-200 p-5 rounded-2xl">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor Rekam Medis</span>
                <div class="text-2xl font-black text-primary mt-1">
                    {{ Auth::user()->no_rm ?? 'BELUM ADA' }}
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 p-5 rounded-2xl">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Terdaftar</span>
                <div class="text-md font-semibold text-slate-700 mt-1">
                    {{ Auth::user()->alamat }}
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex gap-3">
            <a href="{{ route('pasien.daftar') }}" class="btn btn-primary rounded-xl">
                <i class="fas fa-notes-medical mr-2"></i> Daftar Periksa Baru
            </a>
            <a href="{{ route('pasien.riwayat') }}" class="btn btn-outline rounded-xl">
                <i class="fas fa-clock-rotate-left mr-2"></i> Riwayat Pemeriksaan
            </a>
        </div>
    </div>
</x-layouts.app>