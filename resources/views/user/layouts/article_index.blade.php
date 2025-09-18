{{-- お知らせ一覧ページ --}}

@extends('layouts.app')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">お知らせ一覧</h1>

    @if($articles->isEmpty())
        <p class="text-lg text-gray-600">現在お知らせはありません。</p>
    @else
        <ul class="space-y-6">
            @foreach($articles as $article)
                <li class="flex items-center border-b pb-4">

                    {{-- 日付（左側） --}}
                    <span class="text-lg font-bold mr-6 whitespace-nowrap">
                        {{\Carbon\Carbon::parse($article->posted_date)->format('Y/m/d')}}
                    </span>

                    {{-- タイトル --}}
                    <a href="{{ route('user.articles.show', $article->id) }}"
                       class="text-2xl font-bold font-semibold hover:underline truncate"
                       style="max-width: 80%;">
                        {{ $article->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
