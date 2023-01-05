<div>
    <h3>よく使われているタグTOP10</h3>
    <div class="tags">
    @foreach ($popular_tags as $tag)
        <a href="{{ route('sites.index', ['tag'=>$tag->name, 'color' => request()->color, 'favorites' => request()->favorites]) }}" class="tagcloud__item tagcloud__item{{ $tag->level }}">{{ $tag->name }}</a>
    @endforeach
    </div>

    <h3>人気サイトTOP3</h3>
    @foreach ($top3 as $site)
    <div class="site new">
        <p class="site__item site__img">
            <svg data-siteid="{{ $site->id }}" class="like-icon like-icon{{ $site->id }}" xmlns="http://www.w3.org/2000/svg" fill="{{ in_array($site->id, $users_sites) ? "#ffff00" : "#aaaaaa" }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
            <span class="like-number like-number{{ $site->id }}">{{ $site->users_count }}</span>
            <a href="{{ $site->url }}" target="_brank">
                <img src="{{ asset("storage/images/$site->imgsrc") }}" width="500" height="348" alt="{{ $site->title }}">
            </a>
        </p>
        <p class="site__item site__url">
            <a href="{{ $site->url }}" target="_brank">
            {{ $site->url }}
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

    <h3>新着サイト</h3>
    @foreach ($sites as $site)
    <div class="site new">
        <p class="site__item site__img">
            <svg data-siteid="{{ $site->id }}" class="like-icon like-icon{{ $site->id }}" xmlns="http://www.w3.org/2000/svg" fill="{{ in_array($site->id, $users_sites) ? "#ffff00" : "#aaaaaa" }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>
            <span class="like-number like-number{{ $site->id }}">{{ $site->users_count }}</span>
            <a href="{{ $site->url }}" target="_brank">
                <img src="{{ asset("storage/images/$site->imgsrc") }}" width="500" height="348" alt="{{ $site->title }}">
            </a>
        </p>
        <p class="site__item site__url">
            <a href="{{ $site->url }}" target="_brank">
            {{ $site->url }}
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

    <h3>新着タグ</h3>
    <div class="tags">
    @foreach ($tags as $tag)
        <a href="{{ route('sites.index', ['tag'=>$tag->name, 'color' => request()->color, 'favorites' => request()->favorites]) }}" class="tagcloud__item tagcloud__item{{ $tag->level }}">{{ $tag->name }}</a>
    @endforeach
    </div>
</div>