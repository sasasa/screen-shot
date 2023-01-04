<x-layouts.admin>
  <x-slot name="title">{{ $site->title }}管理</x-slot>
  @inject('colorPresenter', '\App\Services\Presenters\ColorService')
<div class="inputbox">
  <a class="logout" href="{{ route('system_admin.logout') }}">ログアウト</a>
  <a href="{{ route('system_admin.sites.index') }}">管理ページトップ</a>
  <a href="{{ route('sites.index') }}">サイトトップページ</a>

</div>
<div class="sites">
    <div class="site">
        <div class="site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site__name">{{ $site->title }}</div>
        <div class="site__url">{{ $site->url }}</div>
        <div class="site__created_at">{{ $site->created_at }}</div>
        <p class="site__item site__description">
            {{ $site->description }}
        </p>
        <p class="site__item site__tags">
        @forelse ($site->tags->map(fn($tag) => $tag->name ) as $tag)
            <a href="{{ route('sites.index', ['tag' => $tag, 'color' => request()->color, 'favorites' => request()->favorites]) }}" class="tag">{{ $tag }}</a>
        @empty
            タグはありません。
        @endforelse
        </p>
        <div class="site__item site__colors">
        <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->mode_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->mode_color }};">
            {{ $site->mode_color }}
        </p>
        <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->second_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->second_color }};">
            {{ $site->second_color }}
        </p>
        <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->third_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->third_color }};">
            {{ $site->third_color }}
        </p>
        <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->darkest_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->darkest_color }};">
            {{ $site->darkest_color }}
        </p>
        <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->brightest_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->brightest_color }};">
            {{ $site->brightest_color }}
        </p>
        <p class="site__tags">
            @foreach ($site->site_colors->map(fn($c) => $c->color) as $color)
            <a href="{{ route('sites.index', ['color' => $color, 'tag' => request()->tag,  'favorites' => request()->favorites]) }}">
                {{ $color }}
            </a>
            @endforeach
        </p>
        </div>
        <div class="site__fileupload">
            <form action="{{ route('system_admin.sites.update', ['site' => $site]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input class="form-input" type="file" name="img">
                <input class="form-input" type="submit" value="アップロード">
                @once
                @error("img")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
                @endonce
            </form>
        </div>
        <div class="site__actions">
            <a class="destroy" href="{{ route('system_admin.sites.destroy', ['site' => $site]) }}">削除</a>
        </div>
    </div>
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