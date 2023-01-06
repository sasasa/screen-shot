<form action="{{ route('sites.index') }}" method="GET">
    <input type="hidden" name="color" value="{{ request()->color }}">
    <input type="hidden" name="tag" value="{{ request()->tag }}">
    <input type="hidden" name="favorites" value="{{ request()->favorites }}">
    <input class="" type="search" name="search" value="{{ request()->search }}">
    <button class="form-input md:mr-4" type="submit">検索</button>
</form>