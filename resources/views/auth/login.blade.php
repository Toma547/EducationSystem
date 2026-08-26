<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>ログイン</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=M+PLUS+1p:wght@400;500;700&display=swap" rel="stylesheet">
        @vite(['resources/css/auth.css'])
    </head>
    <body>
        <div class="resister-link">
            <a href="{{ route('user.show.register') }}">新規登録はこちら</a>
        </div>
        <h1>ログイン</h1>
        <form method="POST" action="{{ route('user.login') }}">
            @csrf
            <div class="form-group">
                <div class="form-row">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password">
                </div>
            </div>
            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif
            <button type="submit">ログイン</button>
        </form>
    </body>
</html>

