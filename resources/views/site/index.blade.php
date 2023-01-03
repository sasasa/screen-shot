<x-layouts.app>
<x-slot name="title">サイト一覧</x-slot>
<x-slot name="background_color">{{ $background_color }}</x-slot>
@slot('users_sites', $users_sites)
@inject('colorPresenter', '\App\Services\Presenters\ColorService')
<div>
  @if (session('message'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
  @endif
</div>
<div class="inputbox colorbox">
  <div>
    <a class="flex" href="{{ route('sites.index') }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
      </svg>
      ホーム</a>
  </div>
  <div>
    <a class="flex" href="{{ route('sites.create') }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      新規追加</a>
  </div>
  <div class="flex items-center">
    <a class="flex" href="{{ route('sites.index', ['favorites' => 1, 'tag' => request()->tag, 'color'=> request()->color]) }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
      </svg>お気に入り
    </a>
    ：{{ request()->favorites ? "お気に入りサイトのみ" : "全てのサイト" }}
    @if(request()->favorites)
      <button class="ml-2 form-input" onclick="location.href='{{ route('sites.index', ['tag' => request()->tag, 'color'=> request()->color]) }}'">この条件を削除</button>
    @endif
  </div>
  <div class="flex items-center">
    <a class="flex" href="{{ route('sites.tags', ['favorites' => request()->favorites, 'color' => request()->color]) }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
      </svg>タグクラウド
    </a>
    ：{{ request()->tag ?? "無し" }}
    @if(request()->tag)
    <button class="ml-2 form-input" onclick="location.href='{{ route('sites.index', ['favorites' => request()->favorites, 'color'=> request()->color]) }}'">この条件を削除</button>
    @endif
  </div>
  <div>
    <form class="flex items-center" action="{{ route('sites.index', ['favorites' => request()->favorites, 'tag' => request()->tag, 'color'=> request()->color]) }}" method="get">
      <input type="hidden" name="tag" value="{{ request()->tag }}">
      <input type="hidden" name="favorites" value="{{ request()->favorites }}">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
      </svg>
      色選択：<input id="picker">
      ：{{ request()->color ?? "指定無し" }}
      @if(request()->color)
        <button class="ml-2 form-input" onclick="location.href='{{ route('sites.index', ['favorites' => request()->favorites, 'tag' => request()->tag]) }}'">この条件を削除</button>
      @endif
    </form>
  </div>
</div>
<div class="nav_links">
  {{ $sites->onEachSide(1)->links() }}
</div>
<div class="sites-container">
@forelse ($sites as $site)
<div class="site">
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
</div>
@empty
  @if(request()->favorites)
    <p>お気に入りのサイトはありません。星マークをクリックして登録してください！</p>
  @else
    <p>サイトはありません</p>
  @endif
@endforelse
</div>
@once
@push('scripts')
<script type="module">
  /* Mapのkeyとvalueを逆にする */
  const reverseMap = (map) => {
    const reverseMap = new Map();
    map.forEach((value, key) => {
      reverseMap.set(value, key);
    });
    return reverseMap;
  };
  /* objectをMapに変換する */
  const objectToMap = (obj) => {
    const map = new Map();
    Object.keys(obj).forEach((key) => {
      map.set(key, obj[key]);
    });
    return map;
  };
  const reverseColorMap = objectToMap(@js($colors));
  const colorMap = reverseMap(reverseColorMap);
  const PINK = "{{ $colors['pink'] }}";
  const RED = "{{ $colors['red'] }}";
  const GREEN = "{{ $colors['green'] }}";
  const DARKGREEN = "{{ $colors['darkgreen'] }}";
  const BLUE = "{{ $colors['blue'] }}";
  const BROWN = "{{ $colors['brown'] }}";
  const SKYBLUE = "{{ $colors['skyblue'] }}";
  const YELLOW = "{{ $colors['yellow'] }}";
  const ORANGE = "{{ $colors['orange'] }}";
  const PURPLE = "{{ $colors['purple'] }}";
  const BLACK = "{{ $colors['black'] }}";
  const WHITE = "{{ $colors[''] }}";

//カラーピッカー
$("#picker").spectrum({
      // 値の変更(確定)時イベント
      change: function(color){
        color = color.toHexString()
        if(color) {
          document.body.style.backgroundColor = color;
          // Generate hidden input and add it to the form
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'color';
          input.value = colorMap.get(color)
          this.form.appendChild(input);
          this.form.submit();
        }
      },
      preferredFormat:'hex', // 16進数で表示
      color: "{{ $background_color }}", // 初期値
      // flat:true, // フラットスタイル
      showPaletteOnly: true, // 外観をパレットのみにする
      palette: [
        [
          PINK, RED, GREEN, DARKGREEN,
        ],
        [
          BLUE, BROWN, SKYBLUE, YELLOW,
        ],
        [
          ORANGE, PURPLE, BLACK, WHITE,
        ],
      ]
  });

/** When .alert is displayed, remove the element in 3 seconds. */
const alertElement = document.querySelector('.alert')
if(alertElement) {
  setTimeout(() => {
    alertElement.remove()
  }, 3000)
}
</script>
@endpush
@endonce
</x-layouts.app>