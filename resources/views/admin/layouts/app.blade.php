<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', '管理トップ')</title>
  <link rel="stylesheet" href="{{ asset('/css/admin/top.css') }}">
</head>

<body>
  <header>
    <ul class="banner">
      <form action="#" method="GET">
        <li>
          <button type="submit">授業管理</button>
        </li>
      </form>
      <form action="#" method="GET">
        <li>
          <button type="submit">お知らせ管理</button>
        </li>
      </form>
      <form action="{{ route('show.banner.edit') }}" method="GET">
        <li>
          <button type="submit">バナー管理</button>
        </li>
      </form>
    </ul>

    <form action="{{ route('show.logout') }}" method="POST" id="logout">
      @csrf
      <input type="submit" value="ログアウト" class="logout">
    </form>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>