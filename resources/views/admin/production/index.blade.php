<x-layouts.admin>
<x-slot name="title">Web制作会社管理画面</x-slot>
<x-message />
<x-admin.menu />

<div class="nav_links">
    {{ $productions->links() }}
</div>
<div class="sites">
@foreach ($productions as $production)
    <div class="site">
        <div class="site__name">{{ $production->name }}</div>
        <div class="site__inquiries">問い合わせ数{{ $production->inquiries_count }}</div>
        <div class="site__sites">登録サイト数{{ $production->sites_count }}</div>
        <div class="site__created_at">登録日時{{ $production->created_at }}</div>
        <div class="site__deleted_at">削除日時{{ $production->deleted_at }}</div>
        @if ($production->deleted_at)
        <div class="site__actions">
            <a class="restore" href="{{ route('system_admin.productions.restore', ['production' => $production]) }}">復活する</a>
        </div>
        @else
        <div class="site__actions">
        <a class="" href="{{ route('system_admin.productions.edit', ['production' => $production]) }}">修正する</a>
        </div>
        <div class="site__actions">
            <a class="destroy" href="{{ route('system_admin.productions.destroy', ['production' => $production]) }}">削除する</a>
        </div>
        @endif
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