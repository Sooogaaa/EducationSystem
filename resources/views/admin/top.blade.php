<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理トップ</title>
  <link rel="stylesheet" href="{{ asset('/css/admin/top.css') }}">
</head>

<body>
  @extends('admin.layouts.app')

  @section('title', '管理トップ')

  @section('content')

  <div class="login_user">
    <p>ユーザーネーム：{{ $adminUser->name }}</p>
    <p>メールアドレス：{{ $adminUser->email }}</p>
  </div>
  @endsection
</body>

</html>