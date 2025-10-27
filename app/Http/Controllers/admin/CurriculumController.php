<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCurriculumRequest;
use App\Models\Curriculum;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    // 一覧表示
    public function showCurriculumList()
    {
        $curriculums = Curriculum::with('deliveryTimes')->get();
        $grades = Grade::all();
        return view('admin.culliculum_list', compact('curriculums', 'grades'));
    }

    // 編集画面表示
    public function edit($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $grades = Grade::all();
        return view('admin.culliculum_edit', compact('curriculum', 'grades'));
    }

    // 授業更新処理
    public function update(UpdateCurriculumRequest $request, $id)
    {
        try {
            DB::beginTransaction(); // ✅ トランザクション開始

            $curriculum = Curriculum::findOrFail($id);

            // バリデーション済みデータ取得
            $data = $request->validated();
            $data['alway_delivery_flg'] = $request->has('alway_delivery_flg') ? 1 : 0;

            $curriculum->update($data);

            DB::commit(); // ✅ 成功時コミット

            return redirect()
                ->route('admin.show.curriculum.list')
                ->with('success', '授業情報を更新しました。');
        } catch (\Exception $e) {
            DB::rollBack(); // ❌ エラー時ロールバック

            \Log::error('【授業更新エラー】' . $e->getMessage());

            return back()
                ->withErrors(['error' => '更新に失敗しました。'])
                ->withInput();
        }
    }

    // 学年別フィルター
    public function filterByGrade($gradeId)
    {
    // モデルのスコープを利用して取得
        $curriculums = Curriculum::getByGrade($gradeId);

        return response()->json($curriculums);
    }

}
