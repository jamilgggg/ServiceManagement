<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 min-h-screen">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="sidebar bg-gray-800 w-60 p-4 text-white">
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-ticket-alt mr-2"></i> Tickets
                </a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-chart-line mr-2"></i> Monitoring
                </a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>

            <!-- Main content -->
            <div class="main-content flex-1 bg-white p-4"> <!-- Content takes the remaining space -->
                @if (session('message'))
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
