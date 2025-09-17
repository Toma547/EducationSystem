<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            ->get();

        $delivery_times = DB::table('delivery_times')
            ->whereBetween('delivery_from', [$start_of_month, $end_of_month])
            ->whereIn('curriculums_id', $curriculums->pluck('id'))
            ->get()
            ->groupBy('curriculums_id');

        $visible_curriculums = $curriculums->filter(function ($curriculum) use ($delivery_times) {
            if ($curriculum->alway_delivery_flg == 1) {
                return true;
            }
            return isset($delivery_times[$curriculum->id]) && $delivery_times[$curriculum->id]->isNotEmpty();
        });

        $format_times = [];

        foreach ($delivery_times as $curriculum_id => $times) {
            if (!$visible_curriculums->pluck('id')->contains($curriculum_id)) continue;

            $format_times[$curriculum_id] = collect($times)->map(function ($time) {
                $from = Carbon::parse($time->delivery_from)->format('n月j日 H:i');
                $to = Carbon::parse($time->delivery_to)->format('H:i');
                return "{$from} ~ {$to}";
            })->take(4);
        }

        return view('user/curriculum_list', [
            'available_grades' => $available_grades,
            'curriculums'     => $curriculums,
            'visible_curriculums' => $visible_curriculums,
            'delivery_times'   => $delivery_times,
            'format_times' => $format_times,
            'current_grade_id'  => $gradeId,
            'currentMonth' => $current_month,
            'prevMonth' => $previous_month,
            'nextMonth' => $next_month,
            'current_year_month' => $current_year_month,
        ]);
    }
}
