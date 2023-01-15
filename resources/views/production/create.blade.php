<x-layouts.production>
<x-slot name="title">管理画面</x-slot>
<x-message />
<x-production.menu />
@if(!$production->name || $errors->any())
  <x-production.form :production="$production" />
@else
  <div id="form_box" style="display: none;">
    <x-production.form :production="$production" />
  </div>
  <div class="inputbox">
    <a class="showForm">会社情報を変更する</a>
  </div>
@endif

<div class="nav_links">
    {{ $sites->links() }}
</div>

<div class="sites">
@forelse($sites as $site)
    <div class="site">
        <div class="site__img"><img src="{{ asset("storage/images/$site->imgsrc") }}"></div>
        <div class="site__name">{{ $site->title }}</div>
        <div class="site__url">
            <a href="{{ $site->url }}" target="_blank">
                {{ $site->url }}
            </a>
        </div>
        <div class="site__created_at">{{ $site->created_at }}</div>
        <div class="site__item site__contact">
          <a href="{{ route('contact_us', ['site_id' => $site->id]) }}">問題を知らせる</a>
        </div>
        <div class="site__actions">
            <a href="{{ route('production.sites.edit', ['site' => $site]) }}">修正する</a>
        </div>
        <div class="site__actions">
            <a class="destroy" href="{{ route('production.sites.destroy', ['site' => $site]) }}">削除</a>
        </div>
    </div>
  @empty
  <div class="site">
      <div class="site__name">
        @if (!$production->name)
          まずは会社情報を登録してください。
        @else
          現在ポートフォリオサイトがありません。<br>
          <x-production.alert :production="$production" />
          設定がすんだら、<a href="{{ route('sites.create') }}" target="_blank">こちら</a>から登録してください。
        @endif
      </div>
  </div>
  @endforelse
</div>
@once
@push('scripts')
<script type="module">
// 画面遷移時にsessionStorageにtransitionSourceを削除しておく
sessionStorage.removeItem('transitionSource');

// 会社情報を変更するボタンを押したらフォームを表示する
const showForm = document.querySelector('.showForm');
showForm.addEventListener('click', () => {
    showForm.style.display = 'none';
    // showForm親のinputboxも消す
    const inputBox = showForm.parentNode;
    inputBox.style.display = 'none';
    const formBox = document.getElementById('form_box');
    formBox.style.display = 'block';
});
</script>
@endpush
@endonce
</x-layouts.production>