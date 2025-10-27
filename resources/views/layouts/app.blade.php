<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>動画学習システム</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
      <!-- 授業管理 -->
      <a class="navbar-brand" href="{{ route('admin.show.curriculum.list') }}">授業管理</a>

      <!-- お知らせ管理 -->
      <a class="navbar-brand" href="{{ route('admin.show.article.list') }}">お知らせ管理</a>

      <!-- バナー管理 -->
      <a class="navbar-brand" href="{{ route('admin.show.banner.edit') }}">バナー管理</a>

      <!-- ログアウト -->
      <a class="navbar-brand" href="#"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         ログアウト
     </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    </form>

    </div>

    <!-- 戻る（トップへ） -->
    <a class="navbar-brand" href="{{ url('/admin/top') }}">←戻る</a>
  </nav>

  <main class="container">
    @yield('content')
  </main>
  <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
