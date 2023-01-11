<x-layouts.admin>
<x-slot name="title">{{ $production->name }}の管理画面</x-slot>
<x-message />
<x-admin.menu />

<div class="sites">
<x-production.form :production="$production" :route="route('system_admin.productions.update', ['production' => $production])" />
</div>
@once
@push('scripts')
<script type="module">
</script>
@endpush
@endonce
</x-layouts.admin>