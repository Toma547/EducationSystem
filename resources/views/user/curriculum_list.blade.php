@extends('layouts.app')

@section('title', '時間割ページ')


@section('content')
    <div class="curriculum-list">
        <div class="curriculum-list__top">
            <div class="curriculum-list__top--back">
                <a href="#">←戻る</a>
            </div>
            <div class="curriculum-list__top--month">
                <button class="curriculum-list__top--month-button">◀︎</button>
                <h2>2025年9月スケジュール</h2>
                <button class="curriculum-list__top--month-button">▶︎</button>
            </div>
            <div class="curriculum-list__top--grade">
                <span>
                    {{ $available_grades->firstWhere('id', $current_grade_id)->name }}
                </span>
            </div>
            <div class="curriculum-list__top--logout">
                <a href="#">ログアウト</a>
            </div>
        </div>

        <div class="curriculum-list__aside">
            <div class="curriculum-list__aside--grade">
                <ul>
                    @foreach($available_grades as $grade)
                        <li>
                            <a href="{{ route('show.curriculum', ['gradeId' => $grade->id]) }}"
                                class="{{ $grade->id == $current_grade_id ? 'is-active' : '' }}">
                                {{ $grade->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="curriculum-list__main">
            @foreach ($curriculums as $curriulum)
                <div class="curriculum-list__main--curriculum">
                    <div class="curriculum-list__main--curriculum-thumbnail">
                        <img src="{{ asset($curriculum->thumbnail) }}" alt="授業画像">
                    </div>
                    <div class="curriculum-list__main--curriculum-title">
                        {{ $curriculum->title }}
                    </div>
                    <div class="curriculum-list__main--curriculum-times">
                        <ul>
                            @foreach ($delivery_times[$curriculum->id] ?? [] as $time)
                                <li>
                                    {{ \Carbon\Carbon::parse($time->delivery_from)->format('n月j日 H:i') }}
                                    ~
                                    {{ \Carbon\Carbon::parse($time->delivery_to)->format('H:i') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
