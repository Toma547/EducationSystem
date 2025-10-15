<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\Grade;

class CurriculumController extends Controller
{
    /**
     * 授業一覧表示
     */
    public function showCurriculumList()
    {
        $curriculums = Curriculum::with('deliveryTimes')->get();
        // ファイル名 culliculum_list.blade.php に合わせる
        return view('admin.culliculum_list', compact('curriculums'));
    }

    /**
     * 授業編集画面
     */
    public function edit($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $grades = Grade::all();
        // ファイル名 culliculum_edit.blade.php に合わせる
        return view('admin.culliculum_edit', compact('curriculum', 'grades'));
    }

    /**
     * 授業更新処理
     */
    public function update(Request $request, $id)
{
    $curriculum = Curriculum::findOrFail($id);

    // リクエストデータをすべて取得
    $data = $request->all();

    // ✅ チェックボックスが送られてこないときは 0 を代入
    $data['alway_delivery_flg'] = $request->has('alway_delivery_flg') ? 1 : 0;

    $curriculum->update($data);

    return redirect()->route('admin.show.curriculum.list')
        ->with('success', '授業情報を更新しました');
}

public function filterByGrade($gradeId)
{
    // 該当学年の授業を取得
    $curriculums = Curriculum::with('deliveryTimes', 'grade')
        ->where('grade_id', $gradeId)
        ->get();

    // JSON で返す
    return response()->json($curriculums);
}


}
