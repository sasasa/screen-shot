<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>ログイン</title>
<meta name="viewport" content="width=device-width">
</head>

<body id="top">

<!-- #contents -->
<div id="contents">


  <h1 class="loginTitle">
  Sites
  </h1>


  @if ($errors->any())
    <div class="textBox" style="height:auto;">
  @foreach ($errors->all() as $error)
    <p class="colorRed">{{ $error }}</p>
  @endforeach
    </div>
  @endif


  <form method="POST">
    <div class="loginForm">
      @csrf
      <div><input class="loginInput" name="email" type="email" placeholder="email"></div>

      <div><input class="loginInput" name="password" type="password" value="" placeholder="パスワード"></div>

      <button type="submit">ログイン</button>
    </div>
  </form>


</div>
<!-- /#contents -->

</body>
</html>