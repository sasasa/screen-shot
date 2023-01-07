<x-layouts.admin>
<x-slot name="title">「{{ $site->title }} 」の管理画面</x-slot>
@inject('colorPresenter', '\App\Services\Presenters\ColorService')
<x-message />
<x-admin.menu />
<div class="sites">
    <div class="site gap-y-4">
        <div class="site__crawl">
            <form action="{{ route('system_admin.sites.crawl', ['site' => $site]) }}" method="POST">
                @csrf
                @method('PUT')
                <input class="mt-2 form-input crawl" type="submit" value="再構築">
            </form>
        </div>
        <div class="site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site__fileupload">
            <form action="{{ route('system_admin.sites.update', ['site' => $site]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input class="form-input" type="file" name="img">
                <input class="form-input" type="submit" value="アップロード">
                @error("img")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
            </form>
        </div>
        <div class="site__name">{{ $site->title }}</div>
        <div class="site__url">
            <a href="{{ $site->url }}" target="_blank">
                {{ $site->url }}
            </a>
        </div>
        <div class="site__created_at">{{ $site->created_at }}</div>
        <p class="site__item site__description">
            {{ $site->description }}
        </p>
        <p class="site__item site__tags">
            <form action="{{ route('system_admin.sites.update_tags', ['site' => $site]) }}" method="POST">
                @csrf
                @method('PUT')
                <input class="w-4/5" type="text" name="tags" value="{{ old('tags', $site->tags->map(fn($tag) => "[".$tag->name."]" )->implode(" "))  }}">
                <input class="form-input" type="submit" value="タグ更新">
            </form>
            @error("tags")
                <p class="errorMessage">{{$message}}</p>
            @enderror
        </p>
        <div class="site__item site__colors">
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->light_vibrant)]) style="background-color: #{{ $site->light_vibrant }};">
            {{ $site->light_vibrant }}
            </p>
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->vibrant)]) style="background-color: #{{ $site->vibrant }};">
            {{ $site->vibrant }}
            </p>
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->dark_vibrant)]) style="background-color: #{{ $site->dark_vibrant }};">
            {{ $site->dark_vibrant }}
            </p>
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->light_muted)]) style="background-color: #{{ $site->light_muted }};">
            {{ $site->light_muted }}
            </p>
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->muted)]) style="background-color: #{{ $site->muted }};">
            {{ $site->muted }}
            </p>
            <p @class(['color', 'text-white' => $colorPresenter->isTextColorWhite($site->dark_muted)]) style="background-color: #{{ $site->dark_muted }};">
            {{ $site->dark_muted }}
            </p>

            <p class="site__tags">
                <form action="{{ route('system_admin.sites.update_colors', ['site' => $site]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-y-2">
                        @foreach (['brown', 'black', 'orange', 'pink', 'skyblue', 'red', 'blue', 'yellow', 'green', 'purple','darkgreen'] as $color)
                        <label class="flex items-center gap-4">
                            <input class="form-checkbox" name="colors[]" type="checkbox" value="{{ $color }}" @checked($mycolors->contains($color))>{{ $color }}
                            <input type="number" value="{{ $mycolorsOrders[$color] ?? 0 }}" name="orders[{{ $color }}]" max="100" min="0">
                        </label>
                        @endforeach
                    </div>
                    <input class="form-input" type="submit" value="色更新">
                </form>
                @error("color")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
                @error("order.*")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
            </p>
        </div>

        <div class="site__actions">
            <a class="form-input inline-block mb-2 destroy" href="{{ route('system_admin.sites.destroy', ['site' => $site]) }}">削除</a>
        </div>
    </div>
</div>
@once
@push('scripts')
<script type="module">
/* .crawlがクリックされたら確認confirmを出してからformをsubmitする */
document.querySelectorAll('.crawl').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        if(!confirm('本当に再構築しますか？一旦全てのデータが消えます。')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endpush
@endonce
</x-layouts.admin>