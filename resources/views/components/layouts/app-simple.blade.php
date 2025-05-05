<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-gray-900 transition-colors">
        {{ $slot }}
        @fluxScripts
    </body>
</html>