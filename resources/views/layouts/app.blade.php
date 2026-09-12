<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=M+PLUS+1p:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm app-header">
            <div class="container">
                <div class="header-inner">
                    <ul class="nav-left">
                        <li><a class="nav-button" href="">時間割</a></li>
                        <li><a class="nav-button" href="">授業進捗</a></li>
                        <li><a class="nav-button" href="">プロフィール設定</a></li>
                    </ul>

                    <ul class="nav-right">
                        <form action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-button">
                                ログアウト
                            </button>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
