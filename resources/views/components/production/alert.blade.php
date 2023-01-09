ポートフォリオサイトを登録する前に以下の項目を確認してください。
<ul>
  <li>ポートフォリオサイトのドメイン直下に以下のファイルを置いてください。
    <pre>
      ファイル名：production.json
      ファイル内容：
      {
        "production": "{{ $production->register_url }}",
      }
    </pre>
  </li>
  <li>もしくは以下のタグを設定してください。
    <pre>
      &lt;meta name="production" content="{{ $production->register_url }}"&gt;
    </pre>
  </li>
</ul>