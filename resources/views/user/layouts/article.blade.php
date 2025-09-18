{{-- お知らせ詳細ページ --}}

@extends('layouts.app')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <a href="{{ route('user.articles.index') }}" class="text-lg font-bold hover:underline mb-6 block">
        ← 戻る
    </a>

    <div class="mb-4">
        <p class="text-lg font-bold">
            {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }}
        </p>

        <h1 class="text-3xl font-bold mb-6">{{ $article->title }}</h1>

        <div class="text-xl leading-relaxed whitespace-pre-line">
            {{ $article->article_contents }}
        </div>
    </div>
</div>
@endsection
