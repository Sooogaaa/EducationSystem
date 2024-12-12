<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'ユーザートップ')</title>
  <link rel="stylesheet" href="{{ asset('/css/user/top.css') }}">
</head>

<body>
  <header>
    <ul class="banner">
      <form action="#" method="GET">
        <li>
          <button type="submit">時間割</button>
        </li>
      </form>
      <form action="#" method="GET">
        <li>
          <button type="submit">授業進捗</button>
        </li>
      </form>
      <form action="#" method="GET">
        <li>
          <button type="submit">プロフィール設定</button>
        </li>
      </form>
    </ul>

    <form action="{{ route('user.logout') }}" method="POST" id="logout">
      @csrf
      <input type="submit" value="ログアウト" class="logout">
    </form>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>