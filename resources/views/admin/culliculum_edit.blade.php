@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">授業設定</h4>

    {{-- 授業設定フォーム --}}
    <form action="{{ route('admin.curriculum.update', $curriculum->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- サムネイル --}}
        <div class="mb-3 d-flex align-items-center">
    @if($curriculum->thumbnail)
        {{-- 登録済みの画像がある場合：storage配下から表示 --}}
        <img src="{{ asset('noimage.png') }}" alt="no image">
        width="150" class="me-3 rounded border">
    @else
        {{-- 画像がない場合：public/images/noimage.png を表示 --}}
        <img src="{{ asset('noimage.png') }}" 
             width="150" class="me-3 rounded border">
    @endif


            <div>
                <label for="thumbnail" class="form-label">サムネイル</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control">
            </div>
        </div>

        {{-- 学年 --}}
        <div class="mb-3">
    <label for="grade" class="form-label">学年</label>
    <select name="grade_id" id="grade" class="form-select w-auto" required>
        <option value="">選択してください</option>
        @php
            $grades = [
                '小学校1年生','小学校2年生','小学校3年生','小学校4年生','小学校5年生','小学校6年生',
                '中学校1年生','中学校2年生','中学校3年生',
                '高校1年生','高校2年生','高校3年生'
            ];
        @endphp

        @foreach($grades as $index => $grade)
            <option value="{{ $index + 1 }}" {{ (isset($curriculum) && $curriculum->grade_id == $index + 1) ? 'selected' : '' }}>
                {{ $grade }}
            </option>
        @endforeach
    </select>
</div>


        {{-- 授業名 --}}
        <div class="mb-3 row">
            <label for="title" class="col-sm-2 col-form-label">授業名</label>
            <div class="col-sm-6">
                <input type="text" name="title" id="title" class="form-control"
                       value="{{ old('title', $curriculum->title) }}">
            </div>
        </div>

        {{-- 動画URL --}}
        <div class="mb-3 row">
            <label for="video_url" class="col-sm-2 col-form-label">動画URL</label>
            <div class="col-sm-6">
                <input type="text" name="video_url" id="video_url" class="form-control"
                       value="{{ old('video_url', $curriculum->video_url ?? '') }}">
            </div>
        </div>

        {{-- 授業概要 --}}
        <div class="mb-3 row">
            <label for="description" class="col-sm-2 col-form-label">授業概要</label>
            <div class="col-sm-6">
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $curriculum->description ?? '') }}</textarea>
            </div>
        </div>

        {{-- 常時公開 --}}
        <div class="mb-3 row">
            <div class="col-sm-6 offset-sm-2">
                <div class="form-check">
                    <input type="checkbox" name="alway_delivery_flg" id="alway_delivery_flg"
                           class="form-check-input"
                           {{ old('alway_delivery_flg', $curriculum->alway_delivery_flg) ? 'checked' : '' }}>
                    <label for="alway_delivery_flg" class="form-check-label">常時公開</label>
                </div>
            </div>
        </div>

        <td>
    {{ $curriculum->alway_delivery_flg ? '✅ 常時公開' : '❌ 非公開' }}
</td>


        {{-- 登録ボタン --}}
        <div class="text-center">
            <button type="submit" class="btn btn-secondary px-5">登録</button>
        </div>
    </form>
</div>
@endsection
