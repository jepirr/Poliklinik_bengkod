<x-layouts.app title="Dashboard Dokter">
    <div class="p-4">
        <h1 class="text-2xl font-bold">Selamat Datang, dr. {{ Auth::user()->nama }}</h1>
        <p>Silakan kelola jadwal periksa pasien Anda di sini.</p>
    </div>
</x-layouts.app>