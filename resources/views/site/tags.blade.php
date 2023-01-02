<x-layouts.app>
  <x-slot name="background_color">{{ $background_color }}</x-slot>
  <x-slot name="title">タグクラウド</x-slot>
  @slot('users_sites', $users_sites)
  <div class="tagcloud">
    @foreach ($tags as $tag)
      <a href="{{ route('sites.index', ['tag' => $tag->name, 'color' => request()->color]) }}" class="tagcloud__item tagcloud__item{{ $tag->level }}">{{ $tag->name }}</a>
    @endforeach
  </div>
</x-layouts.app>