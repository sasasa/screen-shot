<x-layouts.app>
<x-slot name="title">サイト一覧</x-slot>
<x-slot name="background_color">{{ $background_color }}</x-slot>
@inject('colorPresenter', '\App\Services\Presenters\ColorService')
<div>
  @if (session('message'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
  @endif
</div>
@if (request()->tag || request()->color)
<div class="inputbox">
  <h2>
    タグ：{{ request()->tag ?? "無し" }}<br>
    色：{{ request()->color ?? "指定無し" }}
  </h2>
  <a href="{{ route('sites.index') }}">条件を削除する</a>
</div>
@endif
<div class="inputbox colorbox">
  <div>
    <a href="{{ route('sites.tags', ['color' => request()->color]) }}">タグクラウド</a>
  </div>
  <div>
    <a href="{{ route('sites.create') }}">新規追加</a>
  </div>
  <div>
    <form action="{{ route('sites.index', ['tag' => request()->tag, 'color'=> request()->color]) }}" method="get">
      <input type="hidden" name="tag" value="{{ request()->tag }}">
      {{-- <select name="color">
        <option value="">色指定無し</option>
        @foreach (['orange', 'pink', 'brown', 'skyblue', 'black', 'red', 'blue', 'yellow', 'green', 'purple', 'darkgreen'] as $color)
          <option value="{{ $color }}" @selected($color == request()->color)>{{ $color }}</option>
        @endforeach
      </select> --}}
      色選択：<input id="picker">
    </form>
  </div>
</div>
<div class="sites-container">
@forelse ($sites as $site)
<div class="site">
  <p class="site__item site__img">
    <svg data-siteid="{{ $site->id }}" class="like-icon like-icon{{ $site->id }}" xmlns="http://www.w3.org/2000/svg" fill="{{ in_array($site->id, $users_sites) ? "#ffff00" : "#aaaaaa" }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
    </svg>
    <span class="like-number like-number{{ $site->id }}">{{ $site->users_count }}</span>
    <img src="{{ asset("storage/images/$site->imgsrc") }}">
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
      <a href="{{ route('sites.index', ['tag' => $tag, 'color' => request()->color]) }}" class="tag">{{ $tag }}</a>
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
  </div>
</div>
@empty
  <p>サイトがありません</p>
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
document.body.style.backgroundColor = "{{ $background_color }}"
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
/* 色の配列から16進数を取得する関数 */
function rgb2hex(rgb) {
  return "#" + rgb.map(function (value) {
    return ("0" + value.toString(16)).slice(-2);
  }).join("");
}

/** When .alert is displayed, remove the element in 3 seconds. */
const alertElement = document.querySelector('.alert')
if(alertElement) {
  setTimeout(() => {
    alertElement.remove()
  }, 3000)
}

// いいね機能
let likeIcons = document.querySelectorAll('.like-icon');
//likeアイコンをクリックしたらSVGの色を変える
likeIcons.forEach(function(likeIcon) {
  likeIcon.addEventListener('click', function() {
    const siteid = this.getAttribute('data-siteid');
    if (this.getAttribute('fill') === '#aaaaaa') {
      // like
      axios.post('/api/likes', {
        siteid: siteid
      }).then((response) => {
        console.log(response);
        this.setAttribute('fill', '#ffff00');
        document.querySelectorAll(".like-icon" + siteid).forEach(function(icon) {
          icon.setAttribute('fill', '#ffff00');
        });
        document.querySelectorAll(`.like-number${siteid}`).forEach(function(likeNumber) {
          likeNumber.textContent = response.data.likes_count;
        });
      }).catch((error) => {
        console.log(error);
      });
    } else {
      // unlike
      axios.delete('/api/likes', {
        data: {
          siteid: siteid
        }
      }).then((response) => {
        console.log(response);
        this.setAttribute('fill', '#aaaaaa');
        document.querySelectorAll(".like-icon" + siteid).forEach(function(icon) {
          icon.setAttribute('fill', '#aaaaaa');
        });
        document.querySelectorAll(`.like-number${siteid}`).forEach(function(likeNumber) {
          likeNumber.textContent = response.data.likes_count;
        });
      }).catch((error) => {
        console.log(error);
      });
    }
  });
});
</script>
@endpush
@endonce
</x-layouts.app>