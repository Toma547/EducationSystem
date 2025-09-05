<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function showCurriculumList($gradeId)
    {
        $available_grades = DB::table('grades')
            ->whereIn('id', function ($query) {
                $query->select('grade_id')
                      ->from('classes_clear_checks')
                      ->where('clear_flg', 1);
            })
            ->get();

        $curriculums = DB::table('curriculums')
            ->where('grade_id', $gradeId)
            ->orWhere('always_delivery_flg', 1)
            ->get();

        $delivery_times = DB::table('delivery_times')
            ->whereIn('curriculum_id', $curriculums->pluck('id'))
            ->get()
            ->groupBy('curriculum_id');

        return view('curriculum_list', [
            'availableGrades' => $availableGrades,
            'curriculums'     => $curriculums,
            'deliveryTimes'   => $deliveryTimes,
            'currentGradeId'  => $gradeId,
        ]);
    }
}
