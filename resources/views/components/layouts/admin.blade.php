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
    <body class="antialiased admin-layout">
        <div class="main-grid">
            <main>
                {{ $slot }}
            </main>
            <aside class="sidebar inputbox">
                <x-admin-sidebar />
            </aside>
        </div>
        @stack('scripts')
        <script type="module">
            /* restoreリンクをクリックしたらフォームを作ってCRSFトークンを追加してPATCHする */
            document.querySelectorAll('.restore').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if(!confirm('復活しますか？')) {
                        return false;
                    }
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.href;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PATCH';
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
            /* destroyリンクをクリックしたらフォームを作ってCRSFトークンを追加してDELETEする */
            document.querySelectorAll('.destroy').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    if(!confirm('削除しますか？')) {
                        return false;
                    }
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = this.href;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                });
            });
            /* logoutリンクをクリックしたらフォームを作ってCRSFトークンを追加してPOSTする */
            document.querySelector('.logout').addEventListener('click', function(e) {
                e.preventDefault();
                if(!confirm('ログアウトしますか？')) {
                    return false;
                }
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.href;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            });
            /** When .alert is displayed, remove the element in 3 seconds. */
            const alertElement = document.querySelector('.alert')
            if(alertElement) {
                setTimeout(() => {
                    alertElement.remove()
                }, 3000)
            }
        </script>
    </body>
</html>