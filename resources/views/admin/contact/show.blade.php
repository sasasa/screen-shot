<x-layouts.admin>
  <x-slot name="title">「{{ $contact->subject }} 」問い合わせ</x-slot>
  <x-message />
  <x-admin.menu />
  <div class="contacts">
    <div>件名：{{ $contact->subject }}</div>
    <div>本文：{!! nl2br(e( $contact->message)) !!}</div>
    @if($contact->site)
      <div>サイト：<a target="_blank" href="{{ route('system_admin.sites.edit', ['site' => $contact->site]) }}">{{  $contact->site->title }}</a></div>
    @endif
    @if ($contact->production)
      <div>Web制作会社：<a target="_blank" href="{{ route('system_admin.productions.edit', ['production' => $contact->production]) }}">{{  $contact->production->name }}</a></div>
    @endif
    <div>作成日：{{ $contact->created_at }}</div>
    <div>IP：{{ $contact->ip }}</div>
    <div>uuid：{{ $contact->uuid }}</div>
  </div>
  <div class="contacts">
    <form method="POST" action="{{ route('system_admin.contacts.update', ['contact' => $contact]) }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="is_done" value="1">
      <button type="submit" class="form-input">{{ $contact->is_done ? "未完了にする" : "完了にする" }}</button>
    </form>
  </div>
  @once
  @push('scripts')
  <script type="module">
  </script>
  @endpush
  @endonce
  </x-layouts.admin>