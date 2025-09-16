@extends('admin.layouts.app')
@section('hide_header')
@endsection

@section('content')

<div class="register__container">
    <div class="register__header">
        <a href="{{ route('admin.login') }}" class="register__header--login">ログインはこちら</a>
    </div>
    <div class="register__title">
        <h1>新規管理ユーザ登録</h1>
    </div>

    <form method="post" action="{{ route('admin.register') }}" class="register__form">
        @csrf

        <div class="register__form--group">
            <label for="name">ユーザーネーム</label>
            <div class="register__form--input">
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="register__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="register__form--group">
            <label for="kana">カナ</label>
            <div class="register__form--input">
                <input type="text" id="kana" name="kana" value="{{ old('kana') }}">
                @error('kana')
                    <div class="register__form--error">{{ $message }}</div>
                @enderror
            </div>    
        </div>

        <div class="register__form--group">
            <label for="email">メールアドレス</label>
            <div class="register__form--input">
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="register__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="register__form--group">
            <label for="password">パスワード</label>
            <div class="register__form--input">
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="register__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="register__form--group">
            <label for="password-confirm">パスワード確認</label>
            <div class="register__form--input">
                <input type="password" id="password-confirm" name="password_confirmation">
                @error('password_confirmation')
                    <div class="register__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="register__form--group">
            <button type="submit" class="register__form--submit">登録</button>
        </div>
    </form>
</div>
@endsection
