（自動返信メール）
※このメールは、ユーザー登録いただくと同時に
システムで自動的に返信するメールです。

{{$production->email}}様　ご登録ありがとうございます。

以下のURLにアクセスしてユーザー登録を完了してください。
---------------------------------------------
{{ route('production.confirm', ['url' => $production->register_url]) }}
---------------------------------------------

※お心当たりがないにも関わらず、このメールが届いた場合は、
　お手数ですが下記までご連絡いただき、メールを削除してください。

--------------------------------------------------
連絡先：admin@sasasa
sasasa 株式会社
© 2023 SASASA, Inc.