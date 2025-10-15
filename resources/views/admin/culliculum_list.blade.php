@extends('layouts.app') {{-- 共通レイアウトがあれば --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- 左サイドバー --}}
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-start">
            {{-- 新規登録 --}}
<a href="{{ route('admin.show.curriculum.create') }}" class="btn btn-success btn-sm mb-2 w-100">新規登録</a>

{{-- 学年ボタン群（縦一列・小さめ） --}}
@foreach(['小学校1年生','小学校2年生','小学校3年生','小学校4年生','小学校5年生','小学校6年生',
        '中学校1年生','中学校2年生','中学校3年生',
        '高校1年生','高校2年生','高校3年生'] as $grade)
    <button type="button" class="btn btn-outline-info btn-sm mb-1 w-100 grade-btn">{{ $grade }}</button>
@endforeach

            </div>
        </div>

        {{-- メインコンテンツ --}}
        <div class="col-md-10">
            <h2>授業一覧</h2>

            {{-- 選択中の学年表示 --}}
            <div class="mb-3">
                <span id="selected-grade" class="text-success fw-bold"></span>
            </div>

            <div class="row">
                @foreach($curriculums as $curriculum)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                        <img src="{{ $curriculum->thumbnail? asset('storage/images/banner/' . $curriculum->thumbnail) : asset('images/noimage.png') }}" class="card-img-top" alt="thumbnail">
                            <div class="card-body">
                                <h5 class="card-title">{{ $curriculum->title }}</h5>
                                <p class="card-text">{{ $curriculum->descripthon }}</p>
                                <p>
                                @if($curriculum->deliveryTimes->isNotEmpty())
    @foreach($curriculum->deliveryTimes as $time)
        {{ \Carbon\Carbon::parse($time->delivery_from)->format('m月d日 H:i') }}
        〜
        {{ \Carbon\Carbon::parse($time->delivery_to)->format('H:i') }}<br>
    @endforeach
@else
    配信日時未設定
@endif



                               </p>


                                <div class="d-flex justify-content-between">
    <a href="{{ route('admin.show.curriculum.edit', $curriculum->id) }}" class="btn btn-primary btn-sm me-2">授業内容編集</a>
    <a href="{{ route('admin.show.delivery.edit', $curriculum->id) }}" class="btn btn-secondary btn-sm">配信日時編集</a>
</div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- 学年ボタンクリック時のJS --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const gradeButtons = document.querySelectorAll('.grade-btn');
    const selectedGrade = document.getElementById('selected-grade');
    const curriculumContainer = document.querySelector('.row'); // カード一覧部分

    // 学年名とIDの対応（GradeテーブルのIDと合わせる）
    const gradeMap = {
        '小学校1年生': 1,
        '小学校2年生': 2,
        '小学校3年生': 3,
        '小学校4年生': 4,
        '小学校5年生': 5,
        '小学校6年生': 6,
        '中学校1年生': 7,
        '中学校2年生': 8,
        '中学校3年生': 9,
        '高校1年生': 10,
        '高校2年生': 11,
        '高校3年生': 12,
    };

    gradeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const gradeName = button.textContent;
            selectedGrade.textContent = `${gradeName} の授業一覧`;
            const gradeId = gradeMap[gradeName];

            // Ajaxリクエスト
            fetch(`/admin/curriculums/filter/${gradeId}`)
                .then(response => response.json())
                .then(data => {
                    // 一旦空に
                    curriculumContainer.innerHTML = '';

                    if (data.length === 0) {
                        curriculumContainer.innerHTML = '<p>この学年の授業はありません。</p>';
                        return;
                    }

                    // カードを再生成
                    data.forEach(curriculum => {
                        const card = `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="${curriculum.thumbnail ? '/storage/images/banner/' + curriculum.thumbnail : '/images/noimage.png'}" class="card-img-top" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-title">${curriculum.title}</h5>
                                        <p>${curriculum.description ?? ''}</p>
                                        <p>
                                            ${curriculum.delivery_times.length > 0 ? curriculum.delivery_times.map(t => 
                                                `${new Date(t.delivery_from).toLocaleString()}〜${new Date(t.delivery_to).toLocaleTimeString()}`
                                            ).join('<br>') : '配信日時未設定'}
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <a href="/admin/curriculum_edit/${curriculum.id}" class="btn btn-primary btn-sm me-2">授業内容編集</a>
                                            <a href="/admin/delivery_edit/${curriculum.id}" class="btn btn-secondary btn-sm">配信日時編集</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        curriculumContainer.insertAdjacentHTML('beforeend', card);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
</script>

@endsection
