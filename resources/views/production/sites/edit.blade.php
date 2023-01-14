<x-layouts.production>
<x-slot name="title">「{{ $site->title }} 」の管理画面</x-slot>
@inject('colorPresenter', '\App\Services\Presenters\ColorService')
<x-message />
<x-production.menu />
<div class="sites">
    <div class="site gap-y-4">
        <div class="site mt-4 site__crawl">
            <p>サイトがリニューアルしたときなど情報を再設定したいときに利用してください。</p>
            <form action="{{ route('production.sites.crawl', ['site' => $site]) }}" method="POST">
                @csrf
                @method('PUT')
                <input class="mt-2 form-input crawl" type="submit" value="再構築">
            </form>
        </div>
        <div class="site site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site site__fileupload">
            <p>自動でスクリーンショットを取得できないときは画像をアップロードしてください。</p>
            <form action="{{ route('production.sites.update', ['site' => $site]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input class="form-input" type="file" name="img">
                <input class="form-input" type="submit" value="アップロード">
                @error("img")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
            </form>
        </div>
        <div class="site">
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
        </div>

        <div class="site">
            <p class="site__item site__tags">
                <p>タグを設定して検索できるようにしてください。</p>
                <form action="{{ route('production.sites.update_tags', ['site' => $site]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input class="w-4/5" type="text" name="tags" value="{{ old('tags', $site->tags->map(fn($tag) => "[".$tag->name."]" )->implode(" "))  }}">
                    <input class="form-input" type="submit" value="タグ更新">
                </form>
                @error("tags")
                    <p class="errorMessage">{{$message}}</p>
                @enderror
            </p>
        </div>

        <div class="site py-4 site__item site__colors">
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
        </div>

        <div class="site">
            <p class="site__item site__colors_orders">
                <form action="{{ route('system_admin.sites.update_colors', ['site' => $site]) }}" method="POST">
                    <p>色で検索させるための設定です。画面で使われている色の割合を設定してください。</p>
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-y-2">
                        @foreach (['brown', 'black', 'orange', 'pink', 'skyblue', 'red', 'blue', 'yellow', 'green', 'purple','darkgreen'] as $color)
                        <label class="grid grid-cols-2 lg:grid-cols-6 items-center gap-4">
                            <span>
                                <input class="mr-4 form-checkbox" name="colors[]" type="checkbox" value="{{ $color }}" @checked(collect(old('colors', $mycolors))->contains($color))>{{ $color }}
                            </span>
                            <input type="number" value="{{ old("orders.$color", $mycolorsOrders[$color] ?? 0) }}" name="orders[{{ $color }}]" max="100" min="0">
                        </label>
                        @endforeach
                    </div>
                    <input class="form-input" type="submit" value="色更新">
                    @error("colors")
                        <p class="errorMessage">{{$message}}</p>
                    @enderror
                    @error("colors.*")
                        <p class="errorMessage">{{$message}}</p>
                    @enderror
                    @error("orders")
                        <p class="errorMessage">{{$message}}</p>
                    @enderror
                    @error("orders.*")
                        <p class="errorMessage">{{$message}}</p>
                    @enderror
                </form>
            </p>
        </div>

        <div class="site site__actions">
            <p>サイト削除したいときに利用してください。</p>
            <form action="{{ route('production.sites.destroy', ['site' => $site]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input class="mt-2 form-input delete" type="submit" value="削除">
            </form orm>
        </div>
    </div>
</div>
@once
@push('scripts')
<script type="module">
/* Scroll slowly to .errorMessage when loading screen */
function scrollToError() {
    const error = document.querySelector('.errorMessage');
    if(error) {
        error.scrollIntoView({behavior: "smooth", block: "center", inline: "center"});
    }
}
window.addEventListener('load', scrollToError);
/* .deleteがクリックされたら確認confirmを出してからformをsubmitする */
document.querySelectorAll('.delete').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        if(!confirm('本当に削除しますか？全てのデータが消えます。')) {
            e.preventDefault();
            return false;
        }
    });
});

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
</x-layouts.production>