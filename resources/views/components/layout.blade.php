<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">

        <div class="flex h-screen">
            <!-- Sidebar -->
            <div class="sidebar bg-gray-800 w-60 h-full p-4 text-white">
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Home</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Current</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Archive</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Monitoring</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Reports</a>
                <a href="#" class="block py-2.5 px-4 rounded-lg hover:bg-gray-700">Back</a>
            </div>

            <!-- Main content -->
            <div class="main-content flex-1 p-8 bg-white">
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
