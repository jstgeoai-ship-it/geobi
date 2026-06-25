<nav class="fixed top-0 left-0 right-0 z-50 bg-black/40 backdrop-blur-md">

    <div class="max-w-7xl mx-auto px-8">

        <div class="flex items-center justify-between h-16">

            <!-- LOGO -->
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height:36px;width:auto;">
            </a>

            <!-- MENU -->
            <div class="hidden md:flex items-center gap-1 text-sm font-medium text-white">

                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors
                          {{ request()->routeIs('home') ? 'text-orange-400 font-semibold' : '' }}">
                    Beranda
                </a>

                <a href="{{ route('katalog.pbbp2') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors
                          {{ request()->routeIs('katalog.pbbp2') ? 'text-orange-400 font-semibold' : '' }}">
                    Katalog
                </a>

                <a href="{{ route('tentang') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors
                          {{ request()->routeIs('tentang') ? 'text-orange-400 font-semibold' : '' }}">
                    Tentang
                </a>

                <a href="{{ route('struktur') }}"
                   class="px-4 py-2 rounded-lg text-white/80 hover:text-white hover:bg-white/5 transition-colors
                          {{ request()->routeIs('struktur') ? 'text-orange-400 font-semibold' : '' }}">
                    Struktur
                </a>

            </div>

            <!-- AUTH -->
            <div class="hidden md:flex items-center gap-3">

                @auth
                    <span class="text-sm text-slate-400">{{ auth()->user()->name }}</span>

                    <a href="{{ route('dashboard') }}"
                       class="text-sm px-4 py-2 rounded-lg text-cyan-400 hover:bg-cyan-400/10 transition-colors">
                        Dashboard
                    </a>

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

        </div>

    </div>

</nav>
