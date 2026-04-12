<x-layouts.app title="Dashboard Dokter">

    {{-- Greeting --}}
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-800 mb-1">
            Selamat Datang, {{ auth()->user()->name ?? 'Dokter' }} 👋
        </h2>
    </div>

</x-layouts.app>