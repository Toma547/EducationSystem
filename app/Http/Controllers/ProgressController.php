<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;

class ProgressController extends Controller
{
    //　ログインユーザーの進捗表示
    public function index()
    {
        $user = Auth::user();

        // 学年リスト（固定12ブロック）
        $grades = [
            '小学生1年生', '小学校2年生', '小学校3年生',
            '小学校4年生', '小学校5年生', '小学校6年生',
            '中学校1年生', '中学校2年生', '中学校3年生',
            '高校1年生', '高校2年生', '高校3年生'
        ];

        // curriculums を grade ごとに取得
        $curriculums = Curriculum::all()->groupBy('grade');

        // ユーザー進捗
        $progress = CurriculumProgress::where('user_id' , $user->id)
                    ->get()
                    ->keyBy('curriculum_id');

        return view('progress.index', compact('user', 'grades', 'curriculums', 'progress'));
    }

    //　受講済みトグル
    public function toggle(Request $request)
    {
        $progress = CurriculumProgress::find($request->id);

        if (!$progress || $progress->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => '対象データが見つかりません'], 404);
        }

        $progress-> clear_flg = !$progress->clear_flg;
        $progress-> save();

        return response()->json(['status' => 'success', 'completed' => $progress-> clear_flg]);
    }

    //デモ用：「受講しました」ボタン
    public function complete(Request $request, Curriculum $curriculum)
    {
        $progress = CurriculumProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'curriculum_id' => $curriculum->id,
            ],
            ['clear_flg']
        );

        // 受講済みに更新
        $progress->clear_flg = true;
        $progress->save();

        return back()->with('status', '受講済みにしました！');
    }
    
}
