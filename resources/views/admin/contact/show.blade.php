<x-layouts.admin>
  <x-slot name="title">「{{ $contact->subject }} 」問い合わせ</x-slot>
  <x-admin.message />
  <x-admin.menu />
  <div class="contacts">
    <div>{{ $contact->subject }}</div>
    <div>{!! nl2br(e( $contact->message)) !!}</div>
    @if($contact->site)
      <div><a target="_blank" href="{{ route('system_admin.sites.edit', ['site' => $contact->site]) }}">{{  $contact->site->title }}</a></div>
    @endif
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