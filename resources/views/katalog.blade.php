@extends('layouts.app')

@section('content')

<div class="pt-24 px-6">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold text-cyan-400 mb-6">
            Katalog Geoportal
        </h1>

        <p class="text-slate-400 mb-10">
            Pilih dashboard sistem geospasial
        </p>

        <div class="grid md:grid-cols-3 gap-6">

            <a href="{{ route('katalog.pbbp2') }}"
               class="bg-slate-900 p-6 rounded-xl hover:bg-slate-800">

                <h2 class="text-white text-xl font-bold">
                    Dashboard PBB-P2
                </h2>
                <p class="text-slate-400">
                    Peta pajak bumi dan bangunan berbasis PostGIS
                </p>

            </a>

            <a href="{{ route('katalog.bphtb') }}"
               class="bg-slate-900 p-6 rounded-xl hover:bg-slate-800">

                <h2 class="text-white text-xl font-bold">
                    Dashboard BPHTB
                </h2>
                <p class="text-slate-400">
                    Monitoring transaksi BPHTB
                </p>

            </a>

            <a href="{{ route('katalog.reklame') }}"
               class="bg-slate-900 p-6 rounded-xl hover:bg-slate-800">

                <h2 class="text-white text-xl font-bold">
                    Dashboard Reklame
                </h2>
                <p class="text-slate-400">
                    Sebaran objek reklame pajak daerah
                </p>

            </a>

        </div>

    </div>

</div>

@endsection