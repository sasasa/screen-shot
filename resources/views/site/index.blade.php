@vite(['resources/css/app.css', 'resources/js/app.js'])
@inject('colorPresenter', '\App\Services\Presenters\ColorService')
<style>
.grid-auto-fit {
  display: grid;
  border: 1px solid #ddd;
  grid-gap: 10px;
  padding: 10px;
  margin: 1em 0 2em;
  overflow: hidden;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}
.alert-success {
  background-color: #a1dd11;
}
.text-white {
  color: #fff;
}

.site__url {
  word-wrap: break-word;
}
.site__img img {
  /* aspect-ratio: 125 / 87;
  object-fit: cover; */
  width: 100%;
}
</style>
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
      @foreach (['pink', 'brown', 'skyblue', 'black', 'red', 'blue', 'yellow', 'green', 'purple', 'darkgreen'] as $color)
        <option value="{{ $color }}" @selected($color == request()->color)>{{ $color }}</option>
      @endforeach
    </select>
  </form>
</div>
<div class="grid-auto-fit"> 
@foreach ($sites as $site)
<div class="site">
  <p class="site__img">
    <img src="{{ asset("storage/images/$site->imgsrc") }}">
  </p>
  <p class="site__url">
    {{ $site->url }}<br>
    ({{ $site->domain }})
  </p>
  <p>
    {{ $site->title }}
  </p>
  <p>
    {{ $site->description }}
  </p>
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
@endforeach
</div>