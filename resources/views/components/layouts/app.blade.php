<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description ?? '色やタグクラウドでサイトを検索できるサービスです。お気に入り機能でサイトを保存できます。' }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased" style="background-color: {{ $background_color ?? '#fff' }};">
        <div class="main-grid">
            <main>
                {{ $slot }}
            </main>
            <aside class="sidebar inputbox">
                <x-sidebar :users_sites="$users_sites" />
            </aside>
        </div>
        <footer class="footer">
            <div class="flex justify-center flex-wrap gap-x-3 m-2">
                <a href="{{ route('contact_us') }}">お問い合わせ</a>
                <a href="{{ route('terms') }}">利用規約</a>
                <a href="{{ route('privacy') }}">プライバシーポリシー</a>
            </div>
            <div>
                © 2022-{{ now()->format('Y') }} SASASA inc.
            </div>
        </footer>
        @stack('scripts')
    </body>
</html>