@extends('layouts.app')

@section('content')
<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <h2 class="mb-4">配信日時設定 - {{ $curriculum->title }}</h2>

    {{-- 配信スケジュールフォーム --}}
    <form action="{{ route('admin.delivery.store', $curriculum->id) }}" method="POST">
        @csrf
        <input type="hidden" name="curriculums_id" value="{{ $curriculum->id }}">

        <div id="schedule-wrapper">
            {{-- 既存の配信スケジュール（DBから取得したdelivery_times）をループ表示 --}}
            @foreach($curriculum->deliveryTimes as $time)
                <div class="row align-items-center mb-2 schedule-row">
                    {{-- 配信開始日（例: 20250920） --}}
                    <div class="col-md-3">
                        <input type="text" name="delivery_from[]"
                            value="{{ \Carbon\Carbon::parse($time->delivery_from)->format('Ymd') }}"
                            class="form-control" maxlength="8" placeholder="例: 20250920">
                    </div>

                    {{-- 配信開始時刻（例: 1230） --}}
                    <div class="col-md-2">
                        <input type="text" name="start_time[]"
                            value="{{ \Carbon\Carbon::parse($time->delivery_from)->format('Hi') }}"
                            class="form-control" maxlength="4" placeholder="例: 1230">
                    </div>

                    {{-- 配信終了日（例: 20250921） --}}
                    <div class="col-md-3">
                        <input type="text" name="delivery_to[]"
                            value="{{ \Carbon\Carbon::parse($time->delivery_to)->format('Ymd') }}"
                            class="form-control" maxlength="8" placeholder="例: 20250921">
                    </div>

                    {{-- 配信終了時刻（例: 2359） --}}
                    <div class="col-md-2">
                        <input type="text" name="end_time[]"
                            value="{{ \Carbon\Carbon::parse($time->delivery_to)->format('Hi') }}"
                            class="form-control" maxlength="4" placeholder="例: 2359">
                    </div>

                    <div class="col-md-2 text-center">
                        {{-- hiddenで delivery_times.id を渡す（既存データ識別用）--}}
                        <input type="hidden" name="time_ids[]" value="{{ $time->id }}">

                        {{-- 既存行なので削除ボタンを表示 --}}
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $time->id }}">－</button>
                    </div>
                </div>
            @endforeach

            {{-- 空行（新規登録用） --}}
            <div class="row align-items-center mb-2 schedule-row">
                {{-- 配信開始日 --}}
                <div class="col-md-3">
                    <input type="text" name="delivery_from[]" class="form-control" maxlength="8" placeholder="年月日">
                </div>

                {{-- 配信開始時刻 --}}
                <div class="col-md-2">
                    <input type="text" name="start_time[]" class="form-control" maxlength="4" placeholder="日時">
                </div>

                {{-- 配信終了日 --}}
                <div class="col-md-3">
                    <input type="text" name="delivery_to[]" class="form-control" maxlength="8" placeholder="年月日">
                </div>

                {{-- 配信終了時刻 --}}
                <div class="col-md-2">
                    <input type="text" name="end_time[]" class="form-control" maxlength="4" placeholder="日時">
                </div>

                <div class="col-md-2 text-center">
                    {{-- 新規行なので hidden で ID は空 --}}
                    <input type="hidden" name="time_ids[]" value="">
                    {{-- 新規行なので削除ボタンは不要 --}}
                </div>
            </div>
        </div>

        {{-- 追加ボタン --}}
        <div class="mb-3 text-start">
            <button type="button" id="add-row" class="btn btn-success btn-sm">＋</button>
        </div>

        {{-- 登録ボタン --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary">登録</button>
        </div>
    </form>
</div>

{{-- JSで行の追加・削除 --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('schedule-wrapper');
    const addRowBtn = document.getElementById('add-row');

    // 行追加
    addRowBtn.addEventListener('click', () => {
        let templateRow = wrapper.querySelector('.schedule-row:last-child');
        let newRow = templateRow.cloneNode(true);

        // 入力値クリア
        newRow.querySelectorAll('input').forEach(input => input.value = '');

        // 新規行の削除ボタンは無効化 or 非表示
        let deleteBtn = newRow.querySelector('.delete-btn');
        if (deleteBtn) {
            deleteBtn.removeAttribute('data-id'); // 既存IDを消す
        }

        wrapper.appendChild(newRow);
    });

    // Ajax削除
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        if (!id) return alert('DBに存在する行のみ削除可能です');

        if (!confirm('本当に削除しますか？')) return;

        let row = $(this).closest('.schedule-row');
        let csrf = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `/admin/delivery/${id}`,
            type: 'DELETE',
            data: { _token: csrf },
            success: function(response) {
                if (response.success) {
                    row.remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('削除に失敗しました');
            }
        });
    });
});
</script>
@endsection
