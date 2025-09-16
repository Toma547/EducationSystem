<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', '管理画面')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body>
    @if (! View::hasSection('hide_header'))
        <header class="common__header">
            <nav class="common__link--box">
                <a href="#" class="common__link">授業管理</a>
                <a href="#" class="common__link">お知らせ管理</a>
                <a href="#" class="common__link">バナー管理</a>
            </nav>
            <div class="common__logout--box">
                <form action="{{ route('admin.logout') }}" method="post" class="common__logout--form">
                    @csrf
                    <button type="submit" class="common__logout--form-button">
                        ログアウト
                    </button>
                </form>
            </div>
        </header>
    @endif

    <main class="main">
        @yield('content')
    </main>
</body>
</html>
