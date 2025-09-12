<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\CurriculumProgress;

class ProgressController extends Controller
{
    //　ログインユーザーの進捗表示
    public function index()
    {
        $user = Auth::user();

        // DBから学年一覧を取得（順番通り）
        $grades = Grade::orderBy('id')->get();

        // 学年ごとにカリキュラムをまとめる
        $curriculums = [];
        foreach ($grades as $grade) {
            $curriculums[$grade->id] = Curriculum::where('grade_id', $grade->id)->get();
        }

        // ユーザー進捗(curriculums_id をキーにする)
        $progress = CurriculumProgress::where('user_id' , $user->id)
                    ->get()
                    ->keyBy('curriculum_id');

        // 現在の学年を判定
        $currentGrade = null;
        
        foreach ($grades as $grade) {
            $gradeCurriculums = $curriculums[$grade->id] ?? collect();

            if ($gradeCurriculums->isEmpty()) {
                continue;
            }

            // 学年内の全授業クリア済みかどうか
            $allCleared = $gradeCurriculums->every(function ($c) use ($progress) {
                return isset($progress[$c->id]) && $progress[$c->id]->clear_flg;
            });

            if (!$allCleared) {
                $currentGrade = $grade;
                break;
            }
        }

        // 全部クリアしていたら最後の学年を現在学年にする
        if (!$currentGrade) {
            $currentGrade = $grades->last();
        }

        return view('progress.curriculum_progress', compact('user', 'grades', 'curriculums', 'progress', 'currentGrade'));
    }

    //　受講済みトグル
    public function toggle(Request $request)
    {
        $curriculumId = $request->curriculum_id;

        // progressを取得or作成
        $progress = CurriculumProgress::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'curriculum_id' => $curriculumId,
            ],
            ['clear_flg' => false] // 初期は未受講
        );

        // フラグをトグル
        $progress-> clear_flg = !$progress->clear_flg;
        $progress-> save();

        return response()->json([
            'status' => 'success',
            'completed' => $progress-> clear_flg
        ]);
    }

    //デモ用：「受講しました」ボタン
    //public function complete(Request $request, Curriculum $curriculum)
    //{
    //    $progress = CurriculumProgress::firstOrCreate(
    //        [
    //            'user_id' => Auth::id(),
    //            'curriculum_id' => $curriculum->id,
    //        ],
    //        ['clear_flg' => false]
    //    );

        // 受講済みに更新
    //    $progress->clear_flg = true;
    //    $progress->save();

    //    return back()->with('status', '受講済みにしました！');
    }
    
//}
