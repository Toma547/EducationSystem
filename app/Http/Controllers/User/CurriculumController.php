<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Curriculum;

class CurriculumController extends Controller
{
    public function showCurriculumList($gradeId, $yearMonth = null)
    {
        $click_month = $yearMonth
            ? Carbon::createFromFormat('Ym', $yearMonth)
            : Carbon::now();

        $current_year_month = $click_month->format('Ym');
        $current_month = $click_month->format('Y年n月');
        $previous_month = $click_month->copy()->subMonth()->format('Ym');
        $next_month = $click_month->copy()->addMonth()->format('Ym');

        $start_of_month = $click_month->copy()->startOfMonth()->startOfDay();
        $end_of_month = $click_month->copy()->endOfMonth()->endOfDay();

        $available_grades = Curriculum::getAvailableGrades();
        $curriculums = Curriculum::getCurriculumsByGrades($gradeId);
        $delivery_times = Curriculum::getDeliveryTimes($curriculums->pluck('id'), $start_of_month, $end_of_month);
        $visible_curriculums = Curriculum::filterVisibleCurriculums($curriculums, $delivery_times);
        $format_times = Curriculum::formatDeliveryTimes($visible_curriculums, $delivery_times);

        return view('user/curriculum_list', [
            'available_grades' => $available_grades,
            'curriculums' => $curriculums,
            'visible_curriculums' => $visible_curriculums,
            'delivery_times' => $delivery_times,
            'format_times' => $format_times,
            'current_grade_id' => $gradeId,
            'currentMonth' => $current_month,
            'prevMonth' => $previous_month,
            'nextMonth' => $next_month,
            'current_year_month' => $current_year_month,
        ]);
    }
}
