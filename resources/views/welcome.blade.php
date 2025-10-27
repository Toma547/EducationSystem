<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教育システム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">教育システム</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="bg-light text-center py-3 mt-4">
        &copy; {{ date('Y') }} 教育システム
    </footer>
</body>
</html>
