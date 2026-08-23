@extends('layouts.app')

@section('content')

<div class="back-link-wrapper">
    <a class="back-link" href="{{ route('user.show.curriculum') }}">←戻る</a>
</div>
<div class="delivery-content">
    {{-- 動画 --}}
    <div class="video-wrapper">
        <img class="video-thumbnail" src="{{ asset('storage/' . $curriculum->thumbnail) }}" alt="{{ $curriculum->title }}">
        @if ($isAvailable)
            <a href="{{ $curriculum->video_url }}" class="play-button">▶︎</a>
        @else
            <button type="button" class="play-button" disabled>▶︎</button>
        @endif
    </div>
    {{-- 受講ボタン --}}
    @if($progress?->clear_flg)
        <span class="clear-status">受講済み</span>
    @else
        <form method="POST" action="{{ route('user.complete.delivery', ['id' => $curriculum->id]) }}">
            @csrf
            <button type="submit" class="clear-button">受講しました</button>
        </form>
    @endif
</div>

<div class="description">
    <span class="grade-label">{{ $grade->name }}</span>
    <h2 class="class-title">{{ $curriculum->title }}</h2>
    <h3 class="description-title">講座内容</h3>
    <p>{{ $curriculum->description }}</p>
</div>
@endsection
