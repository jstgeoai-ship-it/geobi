<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Bapenda DKI Jakarta')</title>

    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full bg-gray-900 text-white" x-data="{ isOpen: false }">

    <!-- CONTENT -->
    <div class="min-h-full">
        @yield('content')
    </div>

    <!-- MODAL KATALOG -->
    @include('partials.katalog-modal')

    <!-- MODAL CONTROL SCRIPT -->
    <script>
        function openKatalogModal() {
            const modal = document.getElementById('katalogModal');
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeKatalogModal() {
            const modal = document.getElementById('katalogModal');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>