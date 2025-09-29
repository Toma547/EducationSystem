<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者画面</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="p-4 flex justify-between items-center" style="background-color: #4BF0F0;">
        <div class="flex space-x-4">
            <a href="#" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition">授業管理</a>
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition">お知らせ管理</a>
            <a href="#" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition">バナー管理</a>
        </div>
        <div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="text-white font-semibold hover:underline">ログアウト</button>
            </form>
        </div>
    </header>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
