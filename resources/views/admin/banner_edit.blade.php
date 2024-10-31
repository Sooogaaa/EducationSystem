<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理バナー</title>
</head>

<body>
  <header>
    <ul class="transition">
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

    <form action="{{ route('show.logout') }}" method="post" id="logout">
      @csrf
      <input type="submit" class="logout" value="ログアウト">
    </form>
  </header>

  <a href="{{ route('show.top') }}" class="back">戻る</a>

  <h1>バナー管理</h1>
  <form action="{{ route('show.banner.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table id="bannerTable">
      @foreach($banners as $banner)
      <tr>
        <td></td>
      </tr>
    </table>
  </form>
</body>

</html>