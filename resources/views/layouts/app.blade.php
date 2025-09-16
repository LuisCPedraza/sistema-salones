<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
            @include('layouts.navigation')

            <!-- Botón Toggle Tema -->
            <div class="fixed top-4 right-4">
                <button id="theme-toggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 focus:outline-none">
                    <!-- Ícono sol -->
                    <svg id="icon-sun" class="w-6 h-6 hidden text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15a5 5 0 100-10 5 5 0 000 10z"/>
                        <path fill-rule="evenodd" d="M10 1a1 1 0 011 1v1a1 1 0 11-2 0V2a1 1 0 011-1zm0 15a1 1 0 011 1v1a1 1 0 
                        11-2 0v-1a1 1 0 011-1zm9-6a1 1 0 01-1 1h-1a1 1 0 
                        110-2h1a1 1 0 011 1zM3 10a1 1 0 01-1 1H1a1 1 0 
                        110-2h1a1 1 0 011 1zm12.657-6.657a1 1 0 
                        010 1.414L14.414 6.0a1 1 0 11-1.414-1.414l1.243-1.243a1 1 0 
                        011.414 0zM6 14.414a1 1 0 
                        01-1.414 1.414L3.343 14.585a1 1 0 
                        111.414-1.414L6 14.414zM14.414 14.414a1 1 0 
                        011.414 0l1.243 1.243a1 1 0 
                        11-1.414 1.414l-1.243-1.243a1 1 0 
                        010-1.414zM6 5.586a1 1 0 
                        00-1.414-1.414L3.343 5.415a1 1 0 
                        001.414 1.414L6 5.586z" clip-rule="evenodd"/>
                    </svg>
                    <!-- Ícono luna -->
                    <svg id="icon-moon" class="w-6 h-6 hidden text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 
                        016.707 2.707a8.001 8.001 0 
                        1010.586 10.586z"/>
                    </svg>
                </button>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Script toggle -->
        <script>
            const html = document.documentElement;
            const themeToggleBtn = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('icon-sun');
            const moonIcon = document.getElementById('icon-moon');

            // Cargar preferencia inicial
            if (localStorage.theme === 'dark' || 
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
                sunIcon.classList.remove('hidden');
            } else {
                html.classList.remove('dark');
                moonIcon.classList.remove('hidden');
            }

            // Evento de toggle
            themeToggleBtn.addEventListener('click', () => {
                html.classList.toggle('dark');
                if (html.classList.contains('dark')) {
                    localStorage.theme = 'dark';
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    localStorage.theme = 'light';
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
            });
        </script>
    </body>
</html>
