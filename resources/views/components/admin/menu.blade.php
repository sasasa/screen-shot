<div class="inputbox flex-row justify-between">
  <ul class="flex gap-x-4">
    <li>
      <a href="{{ route('system_admin.sites.index') }}">管理ページトップ</a>
    </li>
    <li>
      <a href="{{ route('sites.index') }}" target="_blank">サイトトップページ</a>
    </li>
    <li>
      <a href="{{ route('sites.create') }}" target="_blank">新規追加</a>
    </li>
  </ul>
  <a class="logout" href="{{ route('system_admin.logout') }}">ログアウト</a>
</div>