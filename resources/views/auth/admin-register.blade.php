<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者新規登録</title>
</head>
<body>
    <h2>管理者新規登録</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <div>
            <label>名前:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>カナ</label>
            <input type="text" name="kana" value="{{ old('kana') }}" required>
        </div>

        <div>
            <label>メールアドレス:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>パスワード:</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>パスワード（確認用）:</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>
    <p>
        すでにアカウントはお持ちですか？
        <a href="{{ route('admin.login') }}">ログインはこちら</a>
    </p>
</body>
</html>
