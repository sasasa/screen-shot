<x-layouts.app>
  <x-slot name="title">Web制作会社ログイン</x-slot>
  @slot('users_sites', $users_sites)
  <x-message />
  @if ($errors->any())
    <div class="alert alert-error">
  @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
  @endforeach
    </div>
  @endif
  <form method="POST">
    @csrf
    <div class="inputbox">
      <h2>Web制作会社ログイン</h2>
      <div class="inputbox__inner">
        まずは<a href="{{ route('production.register') }}">こちら</a>から登録していただくと、Web制作会社としてログインが出来るようになります。
      </div>
      <div class="inputbox__inner flex flex-col">
        <label class="inputbox__item inputbox__label" for="email">Email</label>
        <input class="w-full lg:w-3/5 inputbox__item inputbox__email" type="text" id="email" name="email" value="{{ old('email') }}">
        @error('email')
          <p class="errorMessage">{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex flex-col">
        <label class="inputbox__item inputbox__label" for="password">パスワード</label>
        <input class="w-full lg:w-3/5 inputbox__item inputbox__password" type="password" id="password" name="password">
        @error('password')
          <p class="errorMessage">{{$message}}</p>
        @enderror
      </div>
      <div class="inputbox__inner flex-container">
        <button class="form-input inputbox__item inputbox__button" type="button" onclick="location.href='/sites'">戻る</button>
        <button class="form-input inputbox__item inputbox__submit" type="submit">ログイン</button>
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
