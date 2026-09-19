@extends('layouts.app')

@section('content')
    @if ($banners->isNotEmpty())
        <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            {{-- カルーセルインジケータ --}}
            <div class="carousel-indicators">
                @foreach ($banners as $index => $banner)
                    <button type="button"
                        data-bs-target="#bannerCarousel"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"
                        @if ($index === 0) aria-current="true" @endif
                        aria-label="スライド {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>

            {{-- スライド本体 --}}
            <div class="carousel-inner">
                @foreach ($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img
                            src="{{ Storage::url($banner->image) }}"
                            class="banner-image"
                            alt="バナー{{ $index + 1 }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <h2 class="title">お知らせ</h2>
    <div class="article-list">
        @foreach ($articles as $article)
            <a
                class="article-link"
                href="{{ route('user.show.article', ['id' => $article->id]) }}"
            >
                {{ \Carbon\Carbon::parse($article->posted_date)->format('Y年n月j日') }} {{ $article->title }}
            </a>
        @endforeach
    </div>
@endsection
