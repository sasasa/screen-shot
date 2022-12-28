@vite(['resources/css/app.css', 'resources/js/app.js'])
@inject('color', '\App\Services\Presenters\ColorService')
<style>
.grid-auto-fit {
  display: grid;
  border: 1px solid #ddd;
  grid-gap: 10px;
  padding: 10px;
  margin: 1em 0 2em;
  overflow: hidden;
  grid-template-columns: repeat(auto-fit, minmax(1000px, 1fr));
}
.alert-success {
  background-color: #a1dd11;
}
.text-white {
  color: #fff;
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
<div class="grid-auto-fit"> 
@foreach ($sites as $site)
<div>
  <p>
    {{ $site->url }}({{ $site->domain }})
  </p>
  <p>
    <img src="{{ asset("storage/images/$site->imgsrc") }}">
  </p>
  <p>
    {{ $site->title }}
  </p>
  <p>
    {{ $site->description }}
  </p>
  <p @class(['color', 'text-white' => $color->isTextColorWhite($site->mode_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->mode_color }};">
    {{ $site->mode_color }}
  </p>
  <p @class(['color', 'text-white' => $color->isTextColorWhite($site->second_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->second_color }};">
    {{ $site->second_color }}
  </p>
  <p @class(['color', 'text-white' => $color->isTextColorWhite($site->third_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->third_color }};">
    {{ $site->third_color }}
  </p>
  <p @class(['color', 'text-white' => $color->isTextColorWhite($site->darkest_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->darkest_color }};">
    {{ $site->darkest_color }}
  </p>
  <p @class(['color', 'text-white' => $color->isTextColorWhite($site->brightest_color)]) style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->brightest_color }};">
    {{ $site->brightest_color }}
  </p>
</div>
@endforeach
</div>