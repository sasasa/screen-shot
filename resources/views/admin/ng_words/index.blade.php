<x-layouts.admin>
<x-slot name="title">サイト管理画面</x-slot>
<x-message />
<x-admin.menu />
<div class="">
    <a href="{{ route('system_admin.ng_words.create') }}">NGワード新規追加</a>
</div>
<div class="nav_links">
    {{ $ng_words->links() }}
</div>
<div class="sites">
@foreach ($ng_words as $ng_word)
    <div class="site">
        <div class="site__ngword">{{ $ng_word->word }}</div>
        <div class="site__actions">
            <a class="destroy" href="{{ route('system_admin.ng_words.destroy', ['ng_word' => $ng_word]) }}">削除</a>
        </div>
    </div>
@endforeach
</div>
@once
@push('scripts')
<script type="module">
</script>
@endpush
@endonce
</x-layouts.admin>