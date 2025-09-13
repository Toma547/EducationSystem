{{-- お知らせ詳細ページ --}}

@extends('layouts.app')

@section('content')
<div class="p-6">
    <a href="{{ route('user.articles.index') }}" class="text-sm text-gray-600">← 戻る</a>

    <div class="mt-4">
        <p class="text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }}
        </p>

        <h1 class="text-2xl font-bold mt-2">{{ $article->title }}</h1>

        <div class="mt-4 text-lg leading-relaxed">
            {!! nl2br(e($article->article_contents)) !!}
        </div>
    </div>
</div>
@endsection
