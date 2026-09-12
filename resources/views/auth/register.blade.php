<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規登録</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=M+PLUS+1p:wght@400;500;700&display=swap" rel="stylesheet">
        @vite(['resources/css/auth.css'])
    </head>
    <body>
        <div class="resister-link">
            <a href="{{ route('user.show.login') }}">ログインはこちら</a>
        </div>
        <h1>新規登録</h1>
        <form method="POST" action="{{ route('user.register') }}">
            @csrf
            <div class="form-group">
                <div class="form-row">
                    <label for="name">ユーザーネーム</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" @error('name') aria-invalid="true" @enderror>
                </div>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="name_kana">カナ</label>
                    <input type="text" id="name_kana" name="name_kana" value="{{ old('name_kana') }}" @error('name_kana') aria-invalid="true" @enderror>
                </div>
                @error('name_kana')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" @error('email') aria-invalid="true" @enderror>
                </div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" @error('password') aria-invalid="true" @enderror>
                </div>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-row">
                    <label for="password_confirmation">パスワード確認</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>
            <button type="submit">登録</button>
        </form>
    </body>
</html>
