<x-layouts.app>
  <x-slot name="title">タグクラウド</x-slot>
  <div class="tagcloud">
    @foreach ($tags as $tag)
      <a href="{{ route('sites.index', ['tag' => $tag->name, 'color' => request()->color]) }}" class="tagcloud__item tagcloud__item{{ $tag->level }}">{{ $tag->name }}</a>
    @endforeach
  </div>
</x-layouts.app>