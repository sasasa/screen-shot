<x-layouts.app>
  <x-slot name="title">サイト新規追加</x-slot>
  @slot('users_sites', $users_sites)
  <form method="POST" action="{{ route('contacts.store') }}">
    @csrf
    <input type="hidden" name="site_id" value="{{ request()->site_id }}">

    <div class="inputbox">
      <div class="inputbox__inner">
        @if($site)
          {{ $site->title }}について問題を知らせる。
        @else
        ご意見・ご感想をお聞かせください。
        @endif
      </div>
      <div class="inputbox__inner flex flex-col">
        <label class="inputbox__item inputbox__label" for="subject">件名</label>
        <input class="w-full lg:w-3/5 inputbox__item inputbox__url" type="text" id="subject" name="subject" value="{{ old('subject', (request()->site_id ? $site->title. "について" : "")) }}">
        @error('subject')
          <p class="errorMessage">{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex flex-col">
        <label class="inputbox__item inputbox__label" for="message">本文</label>
        <textarea class="h-64 w-full lg:w-3/5 inputbox__item inputbox__textarea" id="message" name="message">{{ old('message') }}</textarea>
        @error('message')
        <p class="errorMessage">{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex-container">
        <button class="form-input inputbox__item inputbox__button" type="button" onclick="location.href='/sites'">戻る</button>
        <button class="form-input inputbox__item inputbox__submit" type="submit">登録</button>
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
