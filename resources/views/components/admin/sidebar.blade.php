<div>
    <h3>新着タグ</h3>
    <div class="tags">
    @foreach ($tags as $tag)
        <a href="{{ route('sites.index', ['tag'=>$tag->name, 'color' => request()->color, 'favorites' => request()->favorites]) }}" class="tagcloud__item tagcloud__item{{ $tag->level }}">{{ $tag->name }}</a>
    @endforeach
    </div>

    <h3>新着サイト</h3>
    @foreach ($sites as $site)
    <div class="site new">
        <p class="site__item site__img">
            <span class="like-number like-number{{ $site->id }}">{{ $site->users_count }}</span>
            <a href="{{ $site->url }}" target="_brank">
                <img src="{{ asset("storage/images/$site->imgsrc") }}" width="500" height="348" alt="{{ $site->title }}">
            </a>
        </p>
        <p class="site__item site__url">
            <a href="{{ $site->url }}" target="_brank">
            {{ $site->url }}<br>
            ({{ $site->domain }})
            </a>
        </p>
        <p class="site__item site__title">
            {{ $site->title }}
        </p>
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
    </div>
    @endforeach

</div>