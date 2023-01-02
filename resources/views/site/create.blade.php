<x-layouts.app>
  <x-slot name="title">サイト新規追加</x-slot>
  @slot('users_sites', $users_sites)
  <div id="loading">
    <div class="spinner"></div>
  </div>
  <form method="POST" action="{{ route('sites.store') }}">
    @csrf
    <div class="inputbox">
      <div class="inputbox__inner">
        <input class="inputbox__item inputbox__url" type="text" name="url" value="{{ old('url') }}">
        @error('url')
          <p>{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex-container">
        <button class="inputbox__item inputbox__button" type="button" onclick="location.href='/sites'">戻る</button>
        <button class="inputbox__item inputbox__submit" type="submit">登録</button>
      </div>
    </div>
  </form>
  @once
  @push('scripts')
  <script>
  /**
   * submitしたら、loadingを表示する
   */
  document.querySelector('.inputbox__submit').addEventListener('click', function() {
    setTimeout(() => {
      this.disabled = true;
    }, 30);
    setTimeout(() => {
      document.getElementById('loading').style.display = 'block';
    }, 1000);
  });
  </script>
  @endpush
  @endonce
</x-layouts.app>
