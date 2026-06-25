<section class="relative min-h-screen overflow-hidden">

    <div class="absolute inset-0">

        <img
            src="{{ asset('img/hero-map.jpg') }}"
            class="w-full h-full object-cover">

    </div>

    <div class="absolute inset-0 bg-slate-950/80"></div>

    <div class="relative z-10 flex min-h-screen items-center justify-center">

        <div class="text-center">

            <div
                class="mb-8 inline-flex items-center rounded-full border border-cyan-500/30 bg-cyan-500/10 px-5 py-2">

                <span class="text-cyan-400">
                    ● BAPENDA DKI Jakarta • Platform Geospasial
                </span>

            </div>

            <img
                src="{{ asset('img/logo-bapenda.png') }}"
                class="h-32 mx-auto mb-8">

            <h1
                class="text-7xl font-bold text-white drop-shadow-[0_0_25px_rgba(56,189,248,0.5)]">

                Geoportal

                <span class="text-cyan-400">

                    Jakarta SmartTax

                </span>

            </h1>

            <p class="mt-6 text-2xl text-slate-300">

                Akses data geospasial perpajakan daerah
                Provinsi DKI Jakarta

            </p>

            <div class="mt-10 flex justify-center gap-4">

                <a
                    href="/login"
                    class="rounded-lg bg-orange-500 px-8 py-4">

                    Masuk

                </a>

                <a
                    href="/katalog"
                    class="rounded-lg border border-cyan-500 px-8 py-4 text-cyan-400">

                    Katalog Data

                </a>

            </div>

        </div>

    </div>

</section>