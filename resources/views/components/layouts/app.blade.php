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
        <header class="header">
            <h1 class="font-bold">
                <a class="no-underline" href="{{ route('sites.index') }}">Beautiful Site List</a>
            </h1>
            <div>
                <span class="css-br">素敵なサイトを見つけて、保存したり、</span>
                <span class="css-br">制作会社に問い合わせたりできる</span>
                サービスです。
            </div>
            <div>
                <x-search-form />
            </div>
        </header>
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
                {{-- ログインしていないときはログインリンク --}}
                @guest('production')
                    <a href="{{ route('production.login') }}">Web制作会社ログイン</a>
                @endguest
                {{-- ログインしているときはログアウトリンク --}}
                @auth('production')
                <a href="{{ route('production.create') }}">Web制作会社管理ページ</a>
                    <form method="POST" action="{{ route('production.logout') }}">
                        @csrf
                        <a href="{{ route('production.logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">ログアウト</a>
                    </form>
                @endauth
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