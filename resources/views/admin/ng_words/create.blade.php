<x-layouts.admin>
  <x-slot name="title">NGワード新規追加</x-slot>
  <form method="POST" action="{{ route('system_admin.ng_words.store') }}">
    @csrf
    <div class="inputbox">
      <div class="inputbox__inner">
        タグクラウドでNGにするワードを入力してください
      </div>
      <div class="inputbox__inner">
        <input class="inputbox__item inputbox__word" type="text" name="word" value="{{ old('word') }}">
        @error('word')
          <p class="errorMessage">{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex-container">
        <button class="form-input inputbox__item inputbox__button" type="button" onclick="location.href='/system_admin/ng_words'">戻る</button>
        <button class="form-input inputbox__item inputbox__submit" type="submit">登録</button>
      </div>
    </div>
  </form>
  @once
  @push('scripts')
  <script>
  </script>
  @endpush
  @endonce
</x-layouts.admin>
