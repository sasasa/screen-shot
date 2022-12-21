<style>
.grid-auto-fit {
  display: grid;
  border: 1px solid #ddd;
  grid-gap: 10px;
  padding: 10px;
  margin: 1em 0 2em;
  overflow: hidden;
  grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
}
</style>
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
  <p style="border: 1px solid #333; width: 100px; height: 100px; background-color: #{{ $site->mode_color }};">
    {{ $site->mode_color }}
  </p>
</div>
@endforeach
</div>