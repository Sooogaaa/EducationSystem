<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理トップ</title>
  <link rel="stylesheet" href="{{ asset('/css/admin/top.css') }})">

</head>

<body>
  @extends('admin.layouts.app')

  @section('title', '管理トップ')

  @section('content')
  <ul class="user_tata">
    <li>ユーザーネーム：{{ $adminUser->name ?? '未ログイン' }}</li>
    <li>メールアドレス：{{ $adminUser->email ?? '未ログイン' }}</li>
  </ul>
  @endsection
</body>

</html>