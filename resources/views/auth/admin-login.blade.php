<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン</title>
</head>
<body>
    <h1>管理者ログイン</h1>

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required autofocus>
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div>
            <button type="submit">管理者ログイン</button>
        </div>
    </form>

    <hr>

    <div>
        <a href="{{ route('admin.register') }}">管理者新規登録はこちら</a>
    </div>
</body>
</html>

