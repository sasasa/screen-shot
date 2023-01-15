<x-layouts.app>
<x-slot name="title">サイト新規追加</x-slot>
<x-slot name="background_color">{{ $background_color }}</x-slot>
@slot('users_sites', $users_sites)
<x-loading-area :background_color="$background_color" />
<form method="POST" action="{{ route('sites.store') }}">
  @csrf
  <div class="inputbox">
    <div class="inputbox__inner">
      登録するサイトのURLをhttps://から入力してください。<br>
      {{-- productionログインしていたら表示する --}}
      @if (Auth::guard('production')->user())
        <x-production.alert :production="Auth::guard('production')->user()" />
      @endif
    </div>
    <div class="inputbox__inner">
      <input type="hidden" name="return_url" value="">
      <input class="inputbox__item inputbox__url" type="text" name="url" value="{{ old('url') }}">
      @error('url')
        <p class="errorMessage">{{$message}}</p>
      @enderror
    </div>
    <div class="inputbox__inner flex-container">
      <button class="form-input inputbox__item inputbox__button back-button" type="button">戻る</button>
      <button class="form-input inputbox__item inputbox__submit" type="submit">登録</button>
    </div>
  </div>
</form>
@once
@push('scripts')
<x-script.referrer />
<x-script.loading />
@endpush
@endonce
</x-layouts.app>
