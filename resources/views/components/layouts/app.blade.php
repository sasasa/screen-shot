<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="background-color: {{ $background_color ?? '#fff' }};">
        <div class="main-grid">
            <main>
                {{ $slot }}
            </main>
            <aside class="sidebar inputbox">
                <x-sidebar :users_sites="$users_sites" />
            </aside>
        </div>
        @stack('scripts')
    </body>
</html>