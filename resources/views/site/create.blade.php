<x-layouts.app>
  <x-slot name="title">サイト新規追加</x-slot>
  <x-slot name="background_color">{{ $background_color }}</x-slot>
  @slot('users_sites', $users_sites)
  <div id="loading">
    <div class="wrapper">
      <div class="circlesWrapper">
        <div class="spinner"></div>
        <div class="circle circleHorizontal circle1"></div>
        <div class="circle circleHorizontal circle2"></div>
        <div class="circle circleHorizontal circle3"></div>
        <div class="circle circleHorizontal circle4"></div>
        <div class="circle circleHorizontal circle5"></div>
        <div class="circle circleHorizontal circle6"></div>
        <div class="circle circleVertical circle7"></div>
        <div class="circle circleVertical circle8"></div>
        <div class="circle circleVertical circle9"></div>
        <div class="circle circleVertical circle10"></div>
        <div class="circle circleVertical circle11"></div>
        <div class="circle circleVertical circle12"></div>
        <div class="mozi">Loading</div>
      </div>
      <div class="cover" style="background-color: {{ $background_color !== '#ffffff' ? $background_color : '#bbb' }};"></div>
    </div>
  </div>
  <form method="POST" action="{{ route('sites.store') }}">
    @csrf
    <div class="inputbox">
      <div class="inputbox__inner">
        登録するサイトのURLをhttpから入力してください。
      </div>
      <div class="inputbox__inner">
        <input class="inputbox__item inputbox__url" type="text" name="url" value="{{ old('url') }}">
        @error('url')
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
