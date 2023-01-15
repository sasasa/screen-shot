<x-layouts.app>
<x-slot name="title">サイト新規追加</x-slot>
@slot('users_sites', $users_sites)
<x-loading-area />
<form method="POST" action="{{ route('contacts.store') }}">
  @csrf
  <input type="hidden" name="site_id" value="{{ request()->site_id }}">
  <input type="hidden" name="return_url" value="">
  <div class="inputbox">
    <div class="inputbox__inner">
      @if($site)
        {{ $site->title }}について<br>
      @endif
      ご意見・ご要望、サムネイル画像差し替え依頼、色の変更依頼、サイトの削除依頼、タグの変更依頼、
      などがありましたら以下のフォームから送信してください。
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
      <button class="form-input inputbox__item inputbox__button back-button" type="button" onclick="">戻る</button>
      <button class="form-input inputbox__item inputbox__submit" type="submit">登録</button>
    </div>
  </div>
</form>
@once
@push('scripts')
<x-script.referrer />
<x-script.loading time="800" />
@endpush
@endonce
</x-layouts.app>
