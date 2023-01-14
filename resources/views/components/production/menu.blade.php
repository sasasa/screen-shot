<div class="inputbox lg:flex-row justify-between flex-col">
  <ul class="flex gap-x-4 lg:flex-row flex-col">
    <li>
      <a href="{{ route('production.create') }}">管理ページトップ</a>
    </li>
    <li>
      <a href="{{ route('sites.index') }}" target="_blank">サイトトップページ</a>
    </li>
    <li>
      <a href="{{ route('sites.create') }}" target="_blank">サイト新規追加</a>
    </li>
  </ul>
  <a class="logout" href="{{ route('production.logout') }}">ログアウト</a>
</div>