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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true }">
        <div class="min-h-screen flex">
            
            <!-- Sidebar -->
            <aside x-show="sidebarOpen" x-transition
                class="bg-gray-800 w-60 p-4 text-white space-y-2 hidden lg:block">
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-ticket-alt mr-2"></i> Tickets
                </a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-chart-line mr-2"></i> Monitoring
                </a>
                <a href="#" class="flex items-center py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </aside>

            <!-- Main content area -->
            <div class="flex-1 flex flex-col">
                <!-- Breeze Top Navigation -->
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>

</html>
