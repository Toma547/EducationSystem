<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\CurriculumProgress;
use App\Models\DeliveryTime;

class DeliveryController extends Controller
{
    /**
     * 配信画面表示
     */
    public function showDelivery($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $grade = Grade::findOrFail($curriculum->grade_id);

        //配信可能か判定
        if ($curriculum->alway_delivery_flg) {
            $isAvailable = true;
        } else {
            $now = now();

            $isAvailable = DeliveryTime::where('curriculums_id', $curriculum->id)
                ->where('delivery_from', '<=', $now)
                ->where('delivery_to', '>=', $now)
                ->exists();
        }

        //現在のユーザーの受講状況
        $progress = CurriculumProgress::where('user_id', auth()->id())
            ->where('curriculum_id', $curriculum->id)
            ->first();

        return view('user.delivery', compact('curriculum', 'grade', 'isAvailable', 'progress'));
    }

    public function complete($id)
    {
        CurriculumProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'curriculum_id' => $id,
            ],
            [
                'clear_flg' => 1,
            ]
        );

        return redirect()->route('user.show.delivery', ['id' => $id]);
    }
}

