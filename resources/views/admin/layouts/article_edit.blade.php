@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    {{-- 戻るリンク --}}
    <a href="{{url()->previous() }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center">
        ← 戻る
    </a>
</div>

<h1 class="text-2xl font-bold mb-4">お知らせ変更</h1>

{{-- エラーメッセージ全体 --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>・{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.articles.update', $article->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block">投稿日時</label>
        <input type="date" name="posted_date" value="{{ old('posted_date', \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d')) }}" class="border p-2 w-full">
        @error('posted_date')
           <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block">タイトル</label>
        <input type="text" name="title" value="{{ old('title', $article->title) }}" class="border p-2 w-full">
        @error('title')
           <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block">本文</label>
        <textarea name="article_contents" class="border p-2 w-full">{{ old('article_contents', $article->article_contents) }}</textarea>
        @error('article_contents')
           <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="px-6 py-2 bg-gray-600 text-white rounded">更新</button>
</form>
@endsection
