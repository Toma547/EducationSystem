@extends('layouts.app') {{-- 共通レイアウトがあれば --}}

@section('content')
<div class="container-fluid">
<div class="row curriculum-list">
        {{-- 左サイドバー --}}
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-start">
            {{-- 新規登録 --}}
<a href="{{ route('admin.show.curriculum.create') }}" class="btn btn-success btn-sm mb-2 w-100">新規登録</a>

        {{-- 学年ボタン群（縦一列・小さめ） --}}
        @foreach($grades as $grade)
    <button class="btn btn-outline-primary grade-filter-btn" data-grade="{{ $grade->id }}">
        {{ $grade->name }}
    </button>
        @endforeach

            </div>
        </div>

        {{-- メインコンテンツ --}}
        <div class="col-md-10">
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
        @endif

            <h2>授業一覧</h2>

            {{-- 選択中の学年表示 --}}
            <div class="mb-3">
                <span id="selected-grade" class="text-success fw-bold"></span>
            </div>

            <div class="row">
                @foreach($curriculums as $curriculum)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                        <img src="{{ $curriculum->thumbnail ? asset('storage/images/' . $curriculum->thumbnail) : asset('images/noimage.png') }}" class="card-img-top" alt="thumbnail">
                        <div class="card-body">
                                <h5 class="card-title">{{ $curriculum->title }}</h5>
                                <p class="card-text">{{ $curriculum->descripthon }}</p>
                                <p>
                                @if($curriculum->deliveryTimes->isNotEmpty())
                                @foreach($curriculum->deliveryTimes as $time)
                                {{ \Carbon\Carbon::parse($time->delivery_from)->format('m月d日 H:i') }} 〜
                                {{ \Carbon\Carbon::parse($time->delivery_to)->format('H:i') }}<br>
                                @endforeach
                                @else
                                <span class="text-muted">配信日時未設定</span>
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
{{-- 学年ボタンクリック時のJS --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const gradeButtons = document.querySelectorAll('.grade-filter-btn'); // ✅ クラス名修正
    const selectedGrade = document.getElementById('selected-grade');
    const curriculumContainer = document.querySelector('.curriculum-list'); // ✅ カード部分を明確に指定

    gradeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const gradeName = button.textContent.trim();
            const gradeId = button.dataset.grade; // ✅ data属性から取得

            selectedGrade.textContent = `${gradeName} の授業一覧`;

            // ✅ Ajaxリクエスト
            fetch(`/admin/curriculums/filter/${gradeId}`)
                .then(response => response.json())
                .then(data => {
                    // 一旦表示を空にする
                    curriculumContainer.innerHTML = '';

                    if (data.length === 0) {
                        curriculumContainer.innerHTML = '<p>この学年の授業はありません。</p>';
                        return;
                    }

                    // ✅ 授業カードを動的に生成
                    data.forEach(curriculum => {
                        const deliveryTimesHtml = curriculum.delivery_times.length > 0
                            ? curriculum.delivery_times.map(t => 
                                `${new Date(t.delivery_from).toLocaleString()}〜${new Date(t.delivery_to).toLocaleTimeString()}`
                              ).join('<br>')
                            : '配信日時未設定';

                        const cardHtml = `
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <img src="${curriculum.thumbnail ? '/storage/images/banner/' + curriculum.thumbnail : '/images/noimage.png'}" class="card-img-top" alt="thumbnail">
                                    <div class="card-body">
                                        <h5 class="card-title">${curriculum.title}</h5>
                                        <p>${curriculum.description ?? ''}</p>
                                        <p>${deliveryTimesHtml}</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="/admin/curriculum_edit/${curriculum.id}" class="btn btn-primary btn-sm me-2">授業内容編集</a>
                                            <a href="/admin/delivery_edit/${curriculum.id}" class="btn btn-secondary btn-sm">配信日時編集</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        curriculumContainer.insertAdjacentHTML('beforeend', cardHtml);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    curriculumContainer.innerHTML = '<p class="text-danger">データの取得に失敗しました。</p>';
                });
        });
    });
});
</script>
@endsection
