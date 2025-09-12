<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen">
            {{-- 共通ヘッダー --}}
            <header class="bg-orange-500 p-3 flex justify-between items-center">
                <div class="flex space-x-4">
                    <a href="{{ url('/curriculum_list') }}" class="bg-teal-400 text-white px-4 py-2 rounded">時間割</a>
                    <a href="{{ route('progress.index') }}" class="bg-teal-600 text-white px-4 py-2 rounded">授業進捗</a>
                    <a href="{{ route('user.profile.edit') }}" class="bg-teal-400 text-white px-4 py-2 rounded">プロフィール設定</a>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white font-bold">ログアウト</button>
                </form>
            </header>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- コンテンツ -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </body>
</html>
