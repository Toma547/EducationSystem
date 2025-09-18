@extends('admin.layouts.app')
@section('hide_header')
@endsection

@section('content')

<div class="login__container">
    <div class="login__header">
        <a href="{{ route('admin.register') }}" class="login__header--register">新規会員登録はこちら</a>
    </div>
    <div class="login__title">
        <h1>管理画面ログイン</h1>
    </div>

    <form method="post" action="{{ route('admin.login') }}" class="login__form">
        @csrf

        <div class="login__form--group">
            <label for="email">メールアドレス</label>
            <div class="login__form--input">
                <input type="email" id="email" name="email">
                @error('email')
                    <div class="login__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="login__form--group">
            <label for="password">パスワード</label>
            <div class="login__form--input">
                <input type="password" id="password" name="password">
                @error('password')
                    <div class="login__form--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="login__form--group">
            <button type="submit" class="login__form--submit">ログイン</button>
        </div>
    </form>
</div>
@endsection
