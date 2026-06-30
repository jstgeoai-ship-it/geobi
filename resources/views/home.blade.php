<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Geoportal Jakarta SmartTax</title>

    @vite(['resources/css/app.css'])

    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

</head>

<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-white transition-colors duration-300">

<!-- NAVBAR -->
@include('partials.navbar')
<nav style="display:none">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex items-center justify-between h-16">

            <!-- LOGO -->
            <a href="{{ url('/home') }}" class="flex-shrink-0">
                <img src="{{ asset('img/logo-bapenda.png') }}" alt="Logo-Bapenda" style="height:36px;width:auto;">
            </a>

            <!-- MENU DESKTOP -->
            <div class="hidden md:flex items-center gap-1 text-sm font-medium">

                <a href="{{ url('/home') }}"
                   class="px-4 py-2 rounded-lg text-orange-400 font-semibold">
                    Beranda
                </a>

                <!-- KATALOG DROPDOWN -->
                <div class="relative" x-data="{ open: false }"
                     @mouseenter="open = true" @mouseleave="open = false">

                    <button class="flex items-center gap-1.5 px-4 py-2 rounded-lg transition-colors text-white/80 hover:text-white hover:bg-white/5"
                            :class="open ? 'bg-white/8 text-white' : ''">
                        Katalog
                        <svg class="w-3.5 h-3.5 opacity-60 transition-transform duration-200"
                             :class="open ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- DROPDOWN PANEL -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-0 top-full pt-2 z-50"
                         style="min-width:360px;">

                        <div class="bg-slate-900 rounded-2xl shadow-2xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.08);">

                            {{-- DASHBOARD PBB-P2 --}}
                            @auth
                            <a href="{{ route('katalog.dashboard') }}"
                               class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @else
                            <a href="{{ route('login') }}"
                               class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @endauth
                                <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500/20 transition-colors">
                                    <svg class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-white group-hover:text-orange-400 transition-colors">Dashboard PBB-P2</p>
                                        <span class="text-xs bg-orange-500/15 text-orange-400 border border-orange-500/25 px-2 py-0.5 rounded-full font-semibold">GEO BI</span>
                                        @guest<svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>@endguest
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Analitik interaktif, chart distribusi, dan peta sebaran pajak.</p>
                                </div>
                            </a>

                            <div class="h-px bg-white/5 mx-5"></div>

                            {{-- PBB-P2 --}}
                            @auth
                            <a href="{{ url('/katalog/pbb-p2') }}"
                               class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @else
                            <a href="{{ route('login') }}"
                               class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @endauth
                                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center flex-shrink-0 group-hover:bg-cyan-500/20 transition-colors">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-white group-hover:text-cyan-400 transition-colors">Katalog PBB-P2</p>
                                        @guest
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        @endguest
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Data geospasial PBB-P2 per wilayah kecamatan DKI Jakarta.</p>
                                </div>
                            </a>

                            <div class="h-px bg-white/5 mx-5"></div>

                            {{-- PAJAK DAERAH — coming soon --}}
                            <div class="flex items-center gap-4 px-5 py-4 opacity-35 cursor-not-allowed select-none">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-white">Katalog Pajak Daerah</p>
                                        <span class="text-xs bg-slate-700 text-slate-400 px-2 py-0.5 rounded-full">Segera</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">Dashboard geospasial PBJT perhotelan, makanan, hiburan, parkir, reklame, dan air tanah.</p>
                                </div>
                            </div>

                            <div class="h-px bg-white/5 mx-5"></div>

                            {{-- JST --}}
                            @auth
                            <a href="#" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group opacity-50 cursor-not-allowed">
                            @else
                            <a href="{{ route('login') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @endauth
                                <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 2.625v5.625"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-white group-hover:text-orange-400 transition-colors">Katalog JST</p>
                                        @guest
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        @endguest
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Dashboard, sistem, dan peta tematik terintegrasi.</p>
                                </div>
                            </a>

                            <div class="h-px bg-white/5 mx-5"></div>

                            {{-- LAINNYA --}}
                            @auth
                            <a href="#" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group opacity-50 cursor-not-allowed">
                            @else
                            <a href="{{ route('login') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-white/5 transition-colors group">
                            @endauth
                                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-white group-hover:text-green-400 transition-colors">Katalog Lainnya</p>
                                        @guest
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        @endguest
                                    </div>
                                    <p class="text-xs text-slate-400 mt-0.5">Akses berkas spreadsheet monitoring & pengukuran.</p>
                                </div>
                            </a>

                        </div>
                    </div>

                </div>

                <a href="{{ url('/tentang') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors">
                    Tentang
                </a>

                <a href="{{ url('/struktur') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors">
                    Struktur
                </a>

            </div>

            <!-- AUTH -->
            <div class="hidden md:flex items-center gap-3">

                @auth
                    <span class="text-sm text-slate-400">
                        {{ auth()->user()->name }}
                    </span>
<form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm px-4 py-2 rounded-lg text-red-400 hover:bg-red-400/10 transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}"
                       class="text-sm px-4 py-2 rounded-lg border border-white/20 text-white/80 hover:bg-white/5 transition-colors">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                        Masuk
                    </a>
                @endauth

            </div>

            <!-- MOBILE -->
            <button class="md:hidden"
                    @click="mobileMenu=!mobileMenu">

                ☰

            </button>

        </div>

    </div>

</nav>

<!-- HERO -->
<section class="relative min-h-screen overflow-hidden">

    <!-- BACKGROUND -->
    <div class="absolute inset-0">

        <img src="{{ asset('img/hero-map.png') }}"
             class="w-full h-full object-cover">

    </div>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-white/50 dark:bg-slate-950/70 transition-colors duration-300"></div>

    <!-- CONTENT -->
    <div class="relative z-10 flex min-h-screen items-center justify-center">

        <div class="text-center max-w-5xl px-6">

            <!-- BADGE -->
            <div class="inline-flex items-center rounded-full border border-cyan-500/30 bg-cyan-500/10 px-4 py-1.5">

                <span class="text-cyan-400 text-xs md:text-sm">
                    ● BAPENDA DKI Jakarta • Platform Geospasial
                </span>

            </div>

            <!-- LOGO -->
            <div class="mt-8">

                <img src="{{ asset('img/logo-bapenda1.png') }}"
                     class="h-32 mx-auto">

            </div>

            <!-- TITLE -->
            <h1 class="mt-8 text-3xl md:text-4xl font-bold leading-tight text-slate-900 dark:text-white transition-colors duration-300">

                SmartMap Geospatial Business Intelligence perubahanbanyaakbgt

                <br>
                <span class="text-cyan-400">
                    Jakarta SmartTax Ohoyy
                </span>

            </h1>

            <!-- SUBTITLE -->
            <p class="mt-6 text-lg md:text-2xl text-slate-600 dark:text-slate-300 transition-colors duration-300">

                Akses data geospasial perpajakan daerah Provinsi DKI Jakarta

            </p>


        </div>

    </div>

</section>

<!-- DARK / LIGHT MODE TOGGLE -->
<div x-data="{ dark: document.documentElement.classList.contains('dark') }"
     x-init="$watch('dark', value => {
         document.documentElement.classList.toggle('dark', value);
         localStorage.setItem('theme', value ? 'dark' : 'light');
     })"
     class="fixed bottom-6 right-6 z-50">

    <button @click="dark = !dark"
            class="w-12 h-12 rounded-full flex items-center justify-center shadow-lg
                   bg-white text-slate-700 hover:bg-slate-100
                   dark:bg-slate-800 dark:text-amber-400 dark:hover:bg-slate-700
                   transition-colors duration-300"
            aria-label="Toggle dark mode">

        <!-- MOON (shown in light mode, click to go dark) -->
        <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
        </svg>

        <!-- SUN (shown in dark mode, click to go light) -->
        <svg x-show="dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.36 6.36l-1.06-1.06M6.7 6.7L5.64 5.64m12.72 0l-1.06 1.06M6.7 17.3l-1.06 1.06M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
        </svg>

    </button>

</div>

</body>
</html>