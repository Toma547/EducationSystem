{{-- お知らせ一覧ページ --}}

@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">お知らせ一覧</h1>

    @if($articles->isEmpty())
        <p class="text-gray-600">現在お知らせはありません。</p>
    @else
        <ul>
            @foreach($articles as $article)
                <li class="mb-3">
                    <a href="{{ route('user.articles.show', $article->id) }}" class="text-blue-600 underline">
                        {{ $article->title }}
                    </a>
                    <span class="text-sm text-gray-500 ml-2">
                        {{ \Carbon\Carbon::parse($article->posted_date)->format('Y/m/d') }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
