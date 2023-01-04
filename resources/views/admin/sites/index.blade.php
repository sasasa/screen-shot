<x-layouts.admin>
  <x-slot name="title">サイト管理</x-slot>
<div class="inputbox">
  <a class="logout" href="{{ route('system_admin.logout') }}">ログアウト</a>
  <a href="{{ route('sites.index') }}">サイトトップページ</a>
</div>
<div class="nav_links">
    {{ $sites->links() }}
  </div>
<div class="sites">
@foreach ($sites as $site)
    <div class="site">
        <div class="site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site__name">{{ $site->title }}</div>
        <div class="site__url">{{ $site->url }}</div>
        <div class="site__created_at">{{ $site->created_at }}</div>
        <div class="site__edit">
            <a class="edit" href="{{ route('system_admin.sites.edit', ['site' => $site]) }}">編集</a>
        </div>
        <div class="site__actions">
            <a class="destroy" href="{{ route('system_admin.sites.destroy', ['site' => $site]) }}">削除</a>
        </div>
    </div>
@endforeach
</div>
@once
@push('scripts')
<script type="module">
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
</script>
@endpush
@endonce
</x-layouts.admin>