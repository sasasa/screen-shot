<x-layouts.admin>
<x-slot name="title">サイト管理画面</x-slot>
<x-admin.message />
<x-admin.menu />
<div class="nav_links">
    {{ $sites->links() }}
  </div>
<div class="sites">
@foreach ($sites as $site)
    <div class="site">
        <div class="site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site__name">{{ $site->title }}</div>
        <div class="site__url">
            <a href="{{ $site->url }}" target="_blank">
                {{ $site->url }}
            </a>
        </div>
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
</script>
@endpush
@endonce
</x-layouts.admin>