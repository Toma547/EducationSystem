@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    {{-- 戻るリンク --}}
    <a href="{{url()->previous() }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center">
        ← 戻る
    </a>
</div>

<h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

{{-- 成功メッセージ --}}
@if(session('success'))
   <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 rounded">
        {{ session('success')}}
   </div>
@endif

{{-- 新規登録ボタン --}}
<div class="mb-6">
    <a href="{{ route('admin.articles.create') }}"
       class="px-6 py-3 bg-green-500 text-white font-semibold rounded shadow hover:bg-green-600 transition">
       新規登録
    </a>
</div>

{{-- お知らせ一覧テーブル --}}
<table class="w-full">
    <thead>
        <tr class="text-left">
            <th class="px-2 py-2">投稿日時</th>
            <th class="px-2 py-2">タイトル</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
        <tr class="border-t">
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }}</td>
            <td class="px-4 py-2">{{ $article->title }}</td>
            <td class="px-4 py-2 flex space-x-2">
                <a href="{{ route('admin.articles.edit', $article->id) }}" class="px-3 py-1 bg-green-600 text-white rounded">変更する</a>
                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('削除してよろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
