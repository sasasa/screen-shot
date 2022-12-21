<form method="POST" action="{{ route('sites.store') }}">
  @csrf
  <div>
    <input type="text" name="url" value="{{ old('url') }}">
    @error('url')
      <p>{{$message}}</p>
    @enderror
  </div>
  <div>
    <button type="submit">登録</button>
  </div>
</form>