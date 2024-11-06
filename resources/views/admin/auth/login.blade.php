<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン画面</title>
    <link rel="stylesheet" href="{{ asset('/css/admin/auth/login.css') }}">
</head>

<body>
    <a href="{{ route('show.register') }}" class="register">
        新規登録はこちら
    </a>
    <h1>管理画面ログイン</h1>

    <form action="{{ route('show.login.send') }}" method="POST">
        @csrf
        <ul>
            <li>
                <label for="e-mail">メールアドレス</label>
                <input type="email" name="email">
            </li>
            <li>
                <label for="password">パスワード</label>
                <input type="password" name="password">
            </li>
        </ul>

        <div class="login">
            <button type="submit">ログイン</button>
        </div>
    </form>

    @if($errors->any())
    <div class="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>

</html>