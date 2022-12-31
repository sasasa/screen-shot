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
<div>
  <a href="{{ route('sites.create') }}">新規追加</a>
</div>
<div>
  <form method="GET">
    <button type="submit">色検索</button>
    <select name="color">
      <option value="">色指定無し</option>
      @foreach (['orange', 'pink', 'brown', 'skyblue', 'black', 'red', 'blue', 'yellow', 'green', 'purple', 'darkgreen'] as $color)
        <option value="{{ $color }}" @selected($color == request()->color)>{{ $color }}</option>
      @endforeach
    </select>
  </form>
</div>
<div class="sites-container">
@foreach ($sites as $site)
<div class="site">
  <p class="site__item site__img">
    <img src="{{ asset("storage/images/$site->imgsrc") }}">
  </p>
  <p class="site__item site__url">
    {{ $site->url }}<br>
    ({{ $site->domain }})
  </p>
  <p class="site__item site__title">
    {{ $site->title }}
  </p>
  <p class="site__item site__description">
    {{ $site->description }}
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
@endforeach
</div>
</x-layouts.app>