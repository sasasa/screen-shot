<div>
  @if (session('message'))
      <div class="alert alert-{{ session('status') }}">
          {{ session('message') }}
      </div>
  @endif
</div>