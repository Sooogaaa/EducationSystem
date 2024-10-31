<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規管理ユーザー登録</title>
    <link rel="stylesheet" href="{{ asset('/css/admin/auth/register.css') }}">
</head>

<body>
    <a href="{{ route('show.login') }}" class="login">
        ログインはこちら
    </a>
    <h1>新規管理ユーザー登録</h1>

    <form action="{{ route('show.register.create') }}" method="POST">
        @csrf
        <ul>
            <li>
                <label for="name">ユーザーネーム</label>
                <input type="name" name="name">
            </li>
            <li>
                <label for="name_kana">カナ</label>
                <input type="name_kana" name="name_kana">
            </li>
            <li>
                <label for="e-mail">メールアドレス</label>
                <input type="email" name="email">
            </li>
            <li>
                <label for="password">パスワード</label>
                <input type="password" name="password">
            </li>
            <li>
                <label for="password">パスワード確認</label>
                <input type="password" name="password_confirmation">
            </li>
        </ul>

        <div class="register">
            <button type="submit">登録</button>
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