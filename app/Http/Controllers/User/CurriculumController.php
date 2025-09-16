<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        foreach ($available_grades as $grade) {
            if (Str::startsWith($grade->name, '小学校')) {
                $grade->class = 'elementary';
            } elseif (Str::startsWith($grade->name, '中学校')) {
                $grade->class ='junior';
            } elseif (Str::startsWith($grade->name, '高校')) {
                $grade->class = 'high';
            } else {
                $grade->class = '';
            }
        }
            
        $curriculums = DB::table('curriculums')
            ->where('grade_id', $gradeId)
            ->orWhere('alway_delivery_flg', 1)
            ->get();

        $delivery_times = DB::table('delivery_times')
            ->whereIn('curriculums_id', $curriculums->pluck('id'))
            ->get()
            ->groupBy('curriculums_id');

        return view('user/curriculum_list', [
            'available_grades' => $available_grades,
            'curriculums'     => $curriculums,
            'delivery_times'   => $delivery_times,
            'current_grade_id'  => $gradeId,
        ]);
    }
}
