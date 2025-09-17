@extends('admin.layouts.app')
@section('title', 'バナー管理')

@section('content')
    <a href="{{ route('admin.show.top') }}" class="banner-edit__back">←戻る</a>
    <div class="banner-edit">
        <h1 class="banner-edit__title">バナー管理</h1>

        <form class="banner-edit__form" action="{{ route('admin.update.banners') }}" method="post" enctype="multipart/form-data" id="bannerForm">
            @csrf
            <div class="banner-edit__list" id="bannerList">
                @foreach($banners as $index => $banner)
                    <div class="banner-edit__list--items">
                        <img src="{{ asset($banner->image) }}" class="banner-edit__list--img">
                        <input type="hidden" name="banners[{{ $index }}][existing_path]" value="{{ $banner->image }}">
                        <input type="file" class="banner-edit__list--file" name="banners[{{ $index }}][file]">
                        <button type="button" class="banner-edit__list--button">-</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="banner-edit__add-button" id="addBanner">+</button>
            <div class="banner-edit__submit">
                <button type="submit" class="banner-edit__submit--button">登録</button>
            </div>
        </form>
    </div>
<script src="{{ asset('js/script.js') }}"></script>
@endsection
