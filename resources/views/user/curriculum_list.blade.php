@extends('user.layouts.app')

@section('title', '時間割ページ')


@section('content')
    <div class="curriculum-list">
        <div class="curriculum-list__top">
            <div class="curriculum-list__top--back">
                <a href="{{ route('user.show.top') }}">←戻る</a>
            </div>
            <div class="curriculum-list__top--month">
                <a href="{{ route('user.show.curriculum', ['gradeId' => $current_grade_id, 'yearMonth' => $prevMonth]) }}">
                    <button class="curriculum-list__top--month-button">◀︎</button>
                </a>
                <h2>{{ $currentMonth }}スケジュール</h2>
                <a href="{{ route('user.show.curriculum', ['gradeId' => $current_grade_id, 'yearMonth' => $nextMonth]) }}">
                    <button class="curriculum-list__top--month-button">▶︎</button>
                </a>
            </div>
            <div class="curriculum-list__top--grade">
                <span>
                    {{ $available_grades->firstWhere('id', $current_grade_id)->name }}
                </span>
            </div>
        </div>

        <div class="curriculum-list__body">
            <div class="curriculum-list__aside">
                <div class="curriculum-list__aside--grade">
                    <ul>
                        @foreach($available_grades as $grade)
                            <li>
                                <a href="{{ route('user.show.curriculum', ['gradeId' => $grade->id, 'yearMonth' => $current_year_month]) }}"
                                    class="{{ $grade->class }}">
                                    {{ $grade->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="curriculum-list__main">
                @foreach ($visible_curriculums as $curriculum)
                    <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}" class="curriculum-list__main--curriculum">
                        <div class="curriculum-list__main--curriculum-thumbnail">
                            <img src="{{ asset($curriculum->thumbnail) }}" alt="授業画像">
                        </div>
                        <div class="curriculum-list__main--curriculum-title">
                            {{ $curriculum->title }}
                        </div>
                        <div class="curriculum-list__main--curriculum-times">
                            <ul>
                                @foreach ($format_times[$curriculum->id] ?? [] as $format)
                                    <li>{{ $format }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
