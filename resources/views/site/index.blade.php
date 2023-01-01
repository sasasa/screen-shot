<x-layouts.app>
<x-slot name="title">サイト一覧</x-slot>
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
<div class="inputbox">
  <div>
    <a href="{{ route('sites.tags') }}">タグクラウド</a>
  </div>
  <div>
    <a href="{{ route('sites.create') }}">新規追加</a>
  </div>
  <div>
    <form action="{{ route('sites.index', ['tag' => request()->tag, 'color'=> request()->color]) }}" method="get">
      <input type="hidden" name="tag" value="{{ request()->tag }}">
      <select name="color">
        <option value="">色指定無し</option>
        @foreach (['orange', 'pink', 'brown', 'skyblue', 'black', 'red', 'blue', 'yellow', 'green', 'purple', 'darkgreen'] as $color)
          <option value="{{ $color }}" @selected($color == request()->color)>{{ $color }}</option>
        @endforeach
      </select>
    </form>
  </div>
</div>
<div class="sites-container">
@forelse ($sites as $site)
<div class="site">
  <p class="site__item site__img">
    <a href="{{ $site->url }}" target="_brank">
      <img src="{{ asset("storage/images/$site->imgsrc") }}">
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
<script>
/**
 * selectboxの値を変更したら、formをsubmitする
 */
const selectbox = document.querySelector('select[name="color"]');
selectbox.addEventListener('change', function() {
  this.form.submit();
});
</script>
@endpush
@endonce
</x-layouts.app>